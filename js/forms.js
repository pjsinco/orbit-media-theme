(function($) {

	$(document).ready(function() {

		var contactFields = 'input[type=text], input[type=email], select, textarea';
        $(".contact-form label").addClass('control-label');
        $(contactFields, $(".contact-form")).addClass('form-control');

        $(".contact-form").submit(function () {
            return validateJetpackContactForm(this);
        });

	});

	/**
	 * VALIDATE CONTACT FORM
	 * (copy this function for every sendform you want to validate
	 * @param  object  contactForm  form to validate
	 * @return  bool  whether the form is valid
	 */
	function validateJetpackContactForm(form){

	    // An array of objects describing the required fields
	    // name is the input field name
	    // title is a human-readable description of that field
	    var requiredFields = new Array();
	    var emailFields = new Array();

	    $('label', $(form)).each(function(){
	        if($(this).has('span').length > 0) {
	            requiredFields.push({name: $(this).attr('for'), title: $(this).text().replace('(required)','')});
	        }
	        if($(this).hasClass('email')) {
	            emailFields.push({name: $(this).attr('for'), title: $(this).text().replace('(required)','')});
	        }
	    });

		return validateForm(form, requiredFields, emailFields);
	}

	/**
	 * Validate Sendform and display errors if not valid
	 * @param  object  form  the form to validate
	 * @param  array  requiredFields  Array of objects describing fields that must not be empty strings
	 * @param  array  emailFields  Array of objects describing fields that must contain valid email addresses (i.e. {name : field name , title: field description}
	 * @return  bool  whether the form is valid
	 */
	function validateForm(form, requiredFields, emailFields) {

		var errors = [];

		var $form = $(form);

		//Remove error fields and labels
		$form.find('.has-error').removeClass('has-error');

		// VALIDATION OF REQUIRED FIELDS
		$(requiredFields).each(function(){

			var $field = $form.find("[id='"+this.name+"']");
			var val = $.trim($field.val());
			var fieldType = getInputType($field);


			// REQUIRE THAT TEXT FIELD, TEXTAREA, OR SELECT VALUE IS NOT BLANK
			if (
				(fieldType == 'text' && val == '')
				|| (fieldType == 'email' && val == '')
				|| (fieldType == 'tel' && val == '')
				|| (fieldType == 'url' && val == '')
				|| (fieldType == 'file' && val == '')
				|| (fieldType == 'select' && val == '')
				|| (fieldType == 'hidden' && val == '')
			) {

				// Displays error message for this field
				var errorMsg = outputErrorMsg(this, 'default');

				// push to error arr
				errors.push({
					name: this.name,
					msg: errorMsg,
					type: fieldType
				});
			}

			// REQUIRE THAT RADIO BE CHECKED OR THAT AT LEAST ONE CHECKBOX BE CHECKED
			if (
			    	(fieldType == 'checkbox' && !$field.is(':checked'))
				|| (fieldType == 'radio' && !$field.is(':checked'))
			){

				// Displays error message for this field
				var errorMsg = outputErrorMsg(this, 'checkbox');

				errors.push({
					name: this.name,
					msg: errorMsg,
					type: fieldType
				});
			}

		});

		// VALIDATION OF EMAIL FIELDS
		if(typeof emailFields != 'undefined' && emailFields.length) {
			$(emailFields).each(function(){

				var $field = $form.find('[name="'+this.name+'"]');
				var val = $.trim($field.val());
				var fieldType = getInputType($field);

				// Displays error message for this field
				var errorMsg = outputErrorMsg(this, 'email');

				if ( val != '' && !isEmailAddress(val)) {
					errors.push({
						name: this.name,
						msg: errorMsg,
						type: fieldType
					});
				}
			});
		}


		if (errors.length) {

			// Validation Failed.  Display errors.

			var error_str = 'Please fix the following:';

			// Compile String of Errors
			if (errors.length > 1) {

				// Multiple Errors

				error_str += '<ul>';
				$(errors).each(function(){
					error_str += '<li>' + this.msg + '</li>';

					// Highlght the label and field that is in error
					addErrorToFieldAndLabel(this, $form);
				});
				error_str += '</ul>';
			}
			else {

				// Only One error

				error_str += '<p>' + errors[0].msg + '</p>';

				// Highlght the label and field that is in error
				addErrorToFieldAndLabel(errors[0], $form);
			}

			// If a msg div doesn't exist inside this form, create one
			$msg_div = $form.find('.alert');
			if ($msg_div.length) {
				$msg_div.hide();
			} else {
				$msg_div = $('<div class="alert alert-danger"></div>').hide().prependTo($form);
			}
			$msg_div.html(error_str).fadeIn();

			// Scroll to top of error msg div
			var errorPos = $msg_div.offset();
			window.scroll(errorPos.left, errorPos.top);

			return false;

		} else {

			//Validation Passed

			// Hide any submit buttons and insert a "Loading..." msg
			$submitBtn = $form.find('.submit, input[type="submit"], input[type="image"]').hide();
			$loadingMsg = $('<div class="loadingMsg">Submitting...</div>').insertAfter($submitBtn);

			return true;
		}
	}

	/**
	 *  Method for outputting the error msg
	 *  @param arr  each row data
	 *  @param str  type of field
	 *      options('checkbox','email','default')
	 *	@return str error msg for each field
	*/
	function outputErrorMsg(field, type) {

	    // Displays error message for each empty field.
		if (typeof field.error != 'undefined' && field.error.length) {

	        // Custom error message for each field, form builder.
			var errorMsg = field.error;

		} else {

	        // Default error message for each field type
	        var errorSuffix;
	        if (type == 'checkbox') {
	            errorSuffix = 'must be checked';
	        } else if (type == 'email') {
	            errorSuffix = 'must be a valid email address';
	        } else {
	            errorSuffix = 'is required';
	        }


			var errorMsg = '<em>' + field.title + '</em> ' + errorSuffix + '.';
		}

	    return errorMsg;
	}

	/**
	 * Get a field type for validation
	 * @param  object  $field  The field
	 * @return  string  field type
	 */
	function getInputType($field){

		var fieldType = 'text';
		if ($field.is('textarea')) {
			fieldType = 'text';
		}
		else if ($field.is('select')) {
			fieldType = 'select';
		}
		else if ($field.attr('type') == 'password') {
			fieldType = 'text';
		}
		else if($field.attr('type')){
			fieldType = $field.attr('type');
		}

		return fieldType;
	}

	/**
	 * Add an error class to the field and label.
	 * @param  object  obj  Object containing the field name and type
	 * @return  void
	 */
	function addErrorToFieldAndLabel(obj, $form){

		var fieldError = 'errorField';
		if(obj.type=='checkbox' && obj.type=='radio') {
			fieldError = obj.type + 'ErrorField';
		}

		//$form.find('[name="'+ obj.name +'"]').addClass(fieldError);
		$form.find('label[for="'+ obj.name +'"]').closest('div').addClass('has-error');
	}

	/**
	 * Function to validate email address for constanct contact newsletter signup form
	 * @param  object form to validate
	 * @return  bool  whether the form is valid
	*/
	/*function validateNewsletterForm(form) {
		var err ="";
		if (!isEmailAddress(form.ea.value)) {
			err += "Your E-mail is invalid"+"\r\n";
		}
		if (err!="") {
			alert(err);
			return false;
		}
		return true;
	}*/

	/**
	 * Validate email address
	 * @param  string  email address
	 * @return  whether the email address is valid
	 */
	function isEmailAddress (string) {
		var addressPattern = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
		return addressPattern.test(string);
	}


	/**
	 * Validate number
	 * @param  string  number
	 * @return  bool  whether the string is a number
	 */
	function isNumeric (string) {
		var objRegExp  = /^[0-9\.]*$/;
		return objRegExp.test(string);
	}

	/**
	 * Validate ZIP
	 * @param  string  ZIP
	 * @return  bool whether the string is a valid US ZIP
	 */
	function validateUSZip(strValue) {
		var objRegExp  = /(^\d{5}$)|(^\d{5}-\d{4}$)/;
		return objRegExp.test(strValue);
	}

	/**
	 * Validate Phone
	 * @param  string  phone
	 * @return  bool whether the string is a valid phone num
	 */
	function validatePhone (string) {
		var objRegExp  = /^\d{3}\-?\d{3}\-?\d{4}$/;
		return(objRegExp.test(string));
	}
})(jQuery);
