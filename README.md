# Twig Bufferized template

This library allows you to delay and reorder the execution of certain portions of Twig template. Twig is designed and 
implemented to execute its template code in linear, top-down order. In majority of use-case scenarios, this is desired
behavior. However, some edge cases demands that certain portions of template code are executed prior to other portions
of codes within the same template.
  
Even though this edge case requirement seams unnatural, some use cases justifies its usage. Some of those, but not limited
to, are presented below:

- Block-like CMS CMF systems (like Sonata project) where layout wraps execution of independent, standalone blocks which
could inflict some global HTML page properties and elements (metadata, javascript and stylesheet inclusions, global error 
and flash messages, etc.)
- Any Twig`include`, `embed` and similar clause which can inflict some global page properties and elements.

## Installation

Library is framework agnostic which means that it can be used in any Twig based project, you just have to install it 
using composer: `composer require runopencode/twig-bufferized-template`.

Of course, presumably that you are familiar with Twig (see [Twig for developers](http://twig.sensiolabs.org/doc/api.html))
you have to register Twig Bufferized template extension to your Twig environment (note that settings given in example are
default settings): 


    $settings = array(
                          'enabled' => true,
                          'nodes' => array(),
                          'whitelist' => array(),
                          'blacklist' => array(),
                          'bufferManager' => 'RunOpenCode\\Twig\\BufferizedTemplate\\Buffer\\BufferManager',
                          'defaultExecutionPriority' => 0,
                          'nodeVisitorPriority' => 10
                    );
                   
    $myTwigEnvironment->addExtension(new \RunOpenCode\Twig\BufferizedTemplate\Extension($settings)); 

If you are satisfied with default settings, you can omit settings from extension constructor, or you can tune up only
desired configuration parameters, since settings are resolved by using `array_merge` function.

### Installing library in Symfony project
 
This library comes with Symfony bundle and extension is already registered in Service Container. You need to register
bundle in your `AppKernel`:

    class AppKernel extends Kernel 
    {
        public function registerBundles()
        {
            $bundles = array(
                [... YOUR BUNDLES...],
                new RunOpenCode\Twig\BufferizedTemplate\Bridge\Symfony\RunOpenCodeTwigBufferizedTemplateBundle()
            );
                
            return $bundles;
        }
    }
           
and if you are not satisfied with default extension configuration, you can configure extension in your `config.yml` (again,
in example below, default configuration is presented):
            
    run_open_code_twig_bufferized_template:
        enabled: true
        nodes: []
        whitelist: []
        blacklist: []
        bufferManager: RunOpenCode\\Twig\\BufferizedTemplate\\Buffer\\BufferManager
        defaultExecutionPriority: 0
        nodeVisitorPriority: 0
        
## How to use extension?
        
Extension comes with prebuilt Twig tag `{% bufferize [priority] %}`. Tag parameter `priority` is optional, and if ommited,
value from `defaultExecutionPriority` configuration setting is used. If you want to rearrange order of execution of some 
portions of your Twig template, wrap it with `{% bufferize %}` and `{% endbufferize %}` tag, example:
 
    <!doctype html>
    <html lang="en">
        <head>
            {% block head %}
                <meta charset="UTF-8">
                <title>Twig test</title>
            {% endblock %}
    
        </head>
        <body>
    
        {%  bufferize 10 %}
    
            This is rendered first                        
    
        {%  endbufferize %}
        
        {% bufferize -10 %}
        
            This is rendered last
                
        {% endbufferize %}
                        
        ..and everything else is rendered in between - if parameter "defaultExecutionPriority" is between (-10, 10)
                        
        </body>
    </html>

**IMPORTANT NOTE**: Execution of template is bufferized within the same rendering context (`template`, `block`, 
`include`, etc). Have in mind that each block should be treated as included template, so each block is separate rendering
context.

## Bufferize existing Twig nodes

If you have some custom tags that needs to be bufferized by default, you can wrap arround that tags with `{% bufferize %}`
and `{%  endbufferize %}` tags. However, you can do that automatically by configuring extension to bufferize your nodes
by default. In order to achieve that, configure extension parameter `nodes` by adding array of full qualified class name
as array key and execution priority as array value, example:

    run_open_code_twig_bufferized_template:
        nodes: 
            - Full\Qualified\Class\Name\To\My\Node: 50
            - Full\Qualified\Class\Name\To\My\OtherNode: -5
            
Note that bufferization will only work for Twig tags. Don't use it for bufferization of functions or tests.
 
## Other configuration parameters

- `enabled`: Enable/disable node visitor to process bufferized nodes. If you have used `{% bufferize %}` tag, it will be just ignored.
- `nodes`: Add other custom Twig tag nodes to template bufferization.
- `whitelist`: By default, all templates are analysed for bufferization. You can explicitly state which templates should be processed with node visitor, others will be ignored. 
- `blacklist`: This parameter is oposite of `whitelist`, here you can state which templates should be ignored. You can use either `whitelist` or `blacklist`, but not booth.
- `bufferManager`: If you need different implementation of buffering execution, you can state FQCN which should be used as buffer manager.
- `defaultExecutionPriority`: Default execution priority of all bufferized template chunks.
- `nodeVisitorPriority`: Twig defines priority of node visitors, which ought to be between [-10, 10]. By using value of 10, bufferizing node visitor will be executed as last node visitor
in process of transforming AST, which is desired behaviour. However, if you need different priority, you can configure that here.

## How bufferization works?
 
In general, for each Twig template that should be bufferized (contains `{% bufferize %}` tag or some configured custom 
bufferized node) each segment of Twig template is wrapped with closure, placing template logic in anonymous function
which is binded to current Twig template class and has access to `$blocks` and `$context` variable by reference.
  
`BufferManager` has reference to mentioned closures, ordered by execution priority. At the end of the block code, `BufferManager`
first executes closures according to their priorities, then echoes them in FIFO order (as Twig is implemented).

## What are drawbacks of using bufferization?

**Memory!** Bufferization uses `ob_start()` and `ob_get_clean()` PHP functions, so each template is first stored in memory,
and then flushed. So you can expect some minor increase of memory usage - but that depends on complexity of your templates.
Note that that increase of memory usage will not be in GBs, it will be more like few KB, or few tens of KBs...

## Give me some stupid example when and why I should use this extension?

This is simple example for Symfony framework. Template will include portion of logic by using possibility to render controller
within the template. That controller can set some global flash variable, with some notice, like "You do not have any 
money on your account", which should be displayed on top of the layout. However, if we execute Twig template in top-down 
order, warning will be rendered prior to execution of desired controller and message will not be displayed.

By using `{% bufferize %}` tag, we can reorder the template execution stack and get desired result. 

    <!doctype html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Twig test</title>
        </head>
        <body>
            {% if app.session.flashbag.get('error') %}
                <div class="alert alert-error">
                    {{ app.session.flashbag.get('notice') }}
                </div>
            {% endif %}
    
        This is my code that I render in my template
        
        {% bufferize 10 %}
        
            {{ render(controller('MyBundle:Article:someController')) }}            
                
        {% endbufferize %}
        
        </body>
    </html>
 
Of course, same result can be achieved by using some different method, per example, on client side via Javascript. 
However, bufferizing is the one of the options as well.

And to achieve this was not easy task, if you are familiar with Sonata project, see: Sonata base layout, 
note `{{ sonata_block_include_stylesheets('screen', app.request.basePath) }}` at the bottom - stylesheets are not loaded 
where they should be - in HEAD tag.

Bufferization could provide method for Sonata project (or any other block-like CMS CMF) proper HTML output and full 
separation of individual block logic that is related to assets management and injection.



