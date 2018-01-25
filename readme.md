# Marksmin 2.0.0 for ExpressionEngine

Marksmin will minify the output of your ExpressionEngine templates. This is extremely useful if you need to count on minified output for inline block elements in your CSS, and can save your end users a few bytes in the process. This extension uses the [Minify](https://code.google.com/p/minify/) library.

To use, enable the extenstion, and place the following parameters in your EE config file.

    $config['marksmin_enabled'] = true;
    $config['marksmin_xhtml'] = false; // Set to true if you're living in the past

That's it. The output of your standard HTML EE templates will now be minified.

View changelog and documentation at: https://buzzingpixel.com/software/marksmin/documentation

## License

Copyright 2018 BuzzingPixel, LLC

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
