// alert('d')
		  var jwk = { /* jwk fetched on the server side */ };
		  var jwk = { /* jwk fetched on the server side */ };

		  var form = document.querySelector('#my-sample-form');
		  var payButton = document.querySelector('#pay-button');

		  // SETUP MICROFORM
		  FLEX.microform(
			{
			  keyId: jwk.kid,
			  keystore: jwk,
			  // keyId: 'bd6300de949e3e6e8e0192d8b49d6066',
			  // keystore: '',
			  container: '#cardNumber-container',
			  label: '#cardNumber-label',
			  placeholder: 'Your custom placeholder text',
			  styles: {
				'input': {
				  'font-size': '14px',
				  'font-family': 'helvetica, tahoma, calibri, sans-serif',
				  'color': '#555',
				},
				':focus': { 'color': 'blue' },
				':disabled': { 'cursor': 'not-allowed' },
				'valid': { 'color': '#3c763d' },
				'invalid': { 'color': '#a94442' },
			  }
			},
			function (setupError, microformInstance) {
			  if (setupError) {
				// handle error
				return;
			  }

			  // intercept the form submission and make a tokenize request instead
			  payButton.addEventListener('click', function () {
				alert('d')
				// Send in optional parameters from other parts of your payment form
				var options = {
				  // cardExpirationMonth: /* ... */,
				  // cardExpirationYear:  /* ... */,
				  // cardType: /* ... */
				};

				microformInstance.createToken(options, function (err, response) {
				  if (err) {
					// handle error
					return;
				  }

				  console.log('Token generated: ');
				  console.log(JSON.stringify(response));

				  // At this point the token may be added to the form
				  // as hidden fields and the submission continued
				  form.submit();
				});
			  });

			}
		  );
	