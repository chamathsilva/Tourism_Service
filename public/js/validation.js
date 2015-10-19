/**
 * Created by chamathsilva on 10/19/15.
 */

$(function(){
    $.validator.setDefaults({
        errorClass: 'help-block',
        highlight: function(element){
            $(element)
                .closest('.form-group')
                .addClass('has-error');
        },

        unhighlight: function(element){
            $(element)
                .closest('.form-group')
                .removeClass('has-error');
        },

        errorPlacement: function(error,element){
            if (element.prop('type') === 'checkbox'){
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });


    $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please")

    $.validator.addMethod('strongPassword',function(value,element){
        return this.optional(element)
            || value.length >= 6
            && /\d/.test(value)
            && /[a-z]/i.test(value);
    }, 'Your password must be at least 6 characters long and contain at least one number and one character.')


    $.validator.addMethod("nowhitespace", function(value, element) {
        return this.optional(element) || /^\S+$/i.test(value);
    }, "No white space please")

    $.validator.addMethod("integer", function(value, element) {
        return this.optional(element) || /^-?\d+$/.test(value);
    }, "A positive or negative non-decimal number please");

    $("#register-form").validate({
        rules:{
            E_mail:{
                required: true,
                email: true
            },
            Password: {
                required: true,
                strongPassword: true

            } ,
            password_again: {
                required: true,
                equalTo: "#Password"
            },
            First_Name:{
                required: true,
                nowhitespace: true,
                lettersonly: true
            },

            Last_Name:{
                required: true,
                nowhitespace: true,
                lettersonly: true
            },

            User_Name:{
                required: true,
                nowhitespace: true,

            },
            terms:{
                required:true
            }

        },
        messages: {
            email: {
                required: 'Please enter an email address.',
                email:'Please enter a <em>valid</em> email address.'
            },
            password2: {
                equalTo: "Please enter the same password again."
            },
            terms:{
                required:"You must agree to the terms and conditions"
            }


        }
    }),


        $("#serviceRegisterForm").validate({
            rules:{
                name:{
                    required: true,

                },
                email: {
                    required: true,
                }
            },
        })


});