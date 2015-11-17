# Twig Bufferized template

This extension allows you to delay and reorder the execution of certain portions of Twig template. Twig is designed and 
implemented to execute its template code in linear, top-down order. In majority of use-case scenarios, this is desired
behavior. However, some edge cases demands that certain portions of template code are executed prior to other portions
of codes within same template.
  
Even though this edge case requirement seams unnatural, some use cases justifies its usage. Some of those, but not limited
to are presented below:

- Block-like CMS CMF systems (like Sonata project) where layout wraps execution of independent, standalone blocks which
could inflict some global HTML page properties and elements (metadata, javascript and stylesheet inclusions, global error 
and flash messages, etc.)
- Any Twig`include`, `embed` and similar clause which can inflict some global page properties and elements.

NOT YET READY FOR RELEASE, NEED COUPLE OF DAYS MORE...