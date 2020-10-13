
    $(document).ready(function() {
        /*
        jQuery.validator.addMethod('accept', function(value, element, param) {
          return value.match(new RegExp('.' + param + '$'));
        });
        */
        jQuery.validator.addMethod('accept', function(value, element, param) {
            return this.optional(element) || param.test(value);
        });
        $('form').validate({
            rules: {
                country_code: {
                                    required: true
                                },country_name: {
                                    required: true
                                }
            },
            messages: {
                country_code: {

                                        },country_name: {

                                        }
            }
        });
    });