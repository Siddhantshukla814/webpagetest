<div class="card subscribe">
  <div class="card-section">
    <div class="info">
      <p>The WebPageTest API gives full access to the power and depth of WebPageTest's analysis, letting you pull performance data into your existing workflows and processes.</p>
    </div>
  </div>
</div>
<form>
  <fieldset class="wpt-plans">
    <legend>Plans</legend>
    <div class="wpt-plan-set annual-plans">
      <?php foreach($annual_plans as $plan) {
$plan_block = <<<HTML
      <input type="radio" id="annual-{$plan['id']}" name="plan" value="" />
      <label class="wpt-plan card" for="annual-{$plan['id']}">
        <span>{$plan['name']}</span>
        <span>${$plan['monthly_price']}/Month</span>
        <span>{$plan['discount']['amount']}</span>
      </label>
HTML;
echo $plan_block;
    }; ?>
    </div>
    <div class="wpt-plan-set monthly-plans">
      <?php foreach($monthly_plans as $plan) {
$plan_block = <<<HTML
      <input type="radio" id="monthly-{$plan['id']}" name="plan" value="" />
      <label class="card wpt-plan" for="monthly-{$plan['id']}">
        <span>{$plan['name']}</span>
        <span>${$plan['price']}/Month</span>
        <span>{$plan['discount']['amount']}</span>
      </label>
HTML;
echo $plan_block;
    }; ?>
    </div>
  </fieldset>
  <div class="card">
    <div>Looking to run more than 20,000 tests in a month?</div>
    <div> <a href="#">Contact Us</a> </div>
  </div>
  <div>
    <div>
      <div>
        <div>
          <div id="braintree-container">
            <div id="braintree--dropin__157501ec-1976-42ed-a7c5-9d75b14ce392" data-braintree-id="wrapper" style="display: none;">
              <?php include_once __DIR__ . '/braintree.svg'; ?>
                <div>
                  <div data-braintree-id="methods-label">&nbsp;</div>
                  <div data-braintree-id="methods-edit">Edit</div>
                  <div data-braintree-id="choose-a-way-to-pay">Choose a way to pay</div>
                  <div class="braintree-placeholder">&nbsp;</div>
                  <div data-braintree-id="upper-container">
                    <div data-braintree-id="loading-container">
                      <div data-braintree-id="loading-indicator">
                        <svg width="14" height="16" class="braintree-loader__lock">
                          <use xlink:href="#iconLockLoader"></use>
                        </svg>
                      </div>
                    </div>
                    <div data-braintree-id="delete-confirmation" class="braintree-delete-confirmation braintree-sheet">
                      <div data-braintree-id="delete-confirmation__message"></div>
                      <div class="braintree-delete-confirmation__button-container">
                        <div role="button" data-braintree-id="delete-confirmation__no" class="braintree-delete-confirmation__button">Cancel</div>
                        <div role="button" data-braintree-id="delete-confirmation__yes" class="braintree-delete-confirmation__button">Delete</div>
                      </div>
                    </div>
                    <div data-braintree-id="methods" class="braintree-methods braintree-methods-initial">
                      <div data-braintree-id="methods-container" class=""></div>
                    </div>
                    <div data-braintree-id="options" class="braintree-test-class braintree-options braintree-options-initial">
                      <div data-braintree-id="payment-options-container" class="braintree-options-list"></div>
                    </div>
                    <div data-braintree-id="sheet-container" class="braintree-sheet__container braintree-sheet--active">
                      <div data-braintree-id="paypal" class="braintree-paypal braintree-sheet">
                        <div data-braintree-id="paypal-sheet-header" class="braintree-sheet__header">
                          <div class="braintree-sheet__header-label">
                            <div class="braintree-sheet__logo--header">
                              <svg width="40" height="24">
                                <use xlink:href="#logoPayPal"></use>
                              </svg>
                            </div>
                            <div class="braintree-sheet__label">PayPal</div>
                          </div>
                        </div>
                        <div class="braintree-sheet__content braintree-sheet__content--button">
                          <div data-braintree-id="paypal-button" class="braintree-sheet__button--paypal"></div>
                        </div>
                      </div>
                      <div data-braintree-id="paypalCredit" class="braintree-paypalCredit braintree-sheet">
                        <div data-braintree-id="paypal-credit-sheet-header" class="braintree-sheet__header">
                          <div class="braintree-sheet__header-label">
                            <div class="braintree-sheet__logo--header">
                              <svg width="40" height="24">
                                <use xlink:href="#logoPayPalCredit"></use>
                              </svg>
                            </div>
                            <div class="braintree-sheet__label">PayPal Credit</div>
                          </div>
                        </div>
                        <div class="braintree-sheet__content braintree-sheet__content--button">
                          <div data-braintree-id="paypal-credit-button" class="braintree-sheet__button--paypal"></div>
                        </div>
                      </div>
                      <div data-braintree-id="applePay" class="braintree-applePay braintree-sheet">
                        <div data-braintree-id="apple-pay-sheet-header" class="braintree-sheet__header">
                          <div class="braintree-sheet__header-label">
                            <div class="braintree-sheet__logo--header">
                              <svg height="24" width="40">
                                <use xlink:href="#logoApplePay"></use>
                              </svg>
                            </div>
                            <div class="braintree-sheet__label">Apple Pay</div>
                          </div>
                        </div>
                        <div class="braintree-sheet__content braintree-sheet__content--button">
                          <div data-braintree-id="apple-pay-button" class="braintree-sheet__button--apple-pay apple-pay-button"></div>
                        </div>
                      </div>
                      <div data-braintree-id="googlePay" class="braintree-googlePay braintree-sheet">
                        <div data-braintree-id="google-pay-sheet-header" class="braintree-sheet__header">
                          <div class="braintree-sheet__header-label">
                            <div class="braintree-sheet__logo--header">
                              <svg height="24" width="40">
                                <use xlink:href="#logoGooglePay"></use>
                              </svg>
                            </div>
                            <div class="braintree-sheet__label">Google Pay</div>
                          </div>
                        </div>
                        <div class="braintree-sheet__content braintree-sheet__content--button">
                          <div data-braintree-id="google-pay-button"></div>
                        </div>
                      </div>
                      <div data-braintree-id="venmo" class="braintree-venmo braintree-sheet">
                        <div data-braintree-id="venmo-sheet-header" class="braintree-sheet__header">
                          <div class="braintree-sheet__header-label">
                            <div class="braintree-sheet__logo--header">
                              <svg height="24" width="40">
                                <use xlink:href="#logoVenmo"></use>
                              </svg>
                            </div>
                            <div class="braintree-sheet__label">Venmo</div>
                          </div>
                        </div>
                        <div class="braintree-sheet__content braintree-sheet__content--button">
                          <svg data-braintree-id="venmo-button" class="braintree-sheet__button--venmo">
                            <use xlink:href="#buttonVenmo"></use>
                          </svg>
                        </div>
                      </div>
                      <div data-braintree-id="card" class="braintree-card braintree-form braintree-sheet">
                        <div data-braintree-id="card-sheet-header" class="braintree-sheet__header">
                          <div class="braintree-sheet__header-label">
                            <div class="braintree-sheet__logo--header">
                              <svg width="40" height="24" class="braintree-icon--bordered">
                                <use xlink:href="#iconCardFront"></use>
                              </svg>
                            </div>
                            <div class="braintree-sheet__text">Pay with card</div>
                          </div>
                          <div data-braintree-id="card-view-icons" class="braintree-sheet__icons">
                            <div data-braintree-id="visa-card-icon" class="braintree-sheet__card-icon">
                              <svg width="40" height="24">
                                <use xlink:href="#icon-visa"></use>
                              </svg>
                            </div>
                            <div data-braintree-id="master-card-card-icon" class="braintree-sheet__card-icon">
                              <svg width="40" height="24">
                                <use xlink:href="#icon-master-card"></use>
                              </svg>
                            </div>
                            <div data-braintree-id="unionpay-card-icon" class="braintree-sheet__card-icon braintree-hidden">
                              <svg width="40" height="24">
                                <use xlink:href="#icon-unionpay"></use>
                              </svg>
                            </div>
                            <div data-braintree-id="american-express-card-icon" class="braintree-sheet__card-icon">
                              <svg width="40" height="24">
                                <use xlink:href="#icon-american-express"></use>
                              </svg>
                            </div>
                            <div data-braintree-id="jcb-card-icon" class="braintree-sheet__card-icon">
                              <svg width="40" height="24">
                                <use xlink:href="#icon-jcb"></use>
                              </svg>
                            </div>
                            <!-- Remove braintree-hidden class when supportedCardType accurately indicates Diners Club support -->
                            <div data-braintree-id="diners-club-card-icon" class="braintree-sheet__card-icon braintree-hidden">
                              <svg width="40" height="24">
                                <use xlink:href="#icon-diners-club"></use>
                              </svg>
                            </div>
                            <div data-braintree-id="discover-card-icon" class="braintree-sheet__card-icon">
                              <svg width="40" height="24">
                                <use xlink:href="#icon-discover"></use>
                              </svg>
                            </div>
                            <div data-braintree-id="maestro-card-icon" class="braintree-sheet__card-icon braintree-hidden">
                              <svg width="40" height="24">
                                <use xlink:href="#icon-maestro"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                        <div class="braintree-sheet__content braintree-sheet__content--form">
                          <div data-braintree-id="cardholder-name-field-group" class="braintree-form__field-group">
                            <label for="braintree__card-view-input__cardholder-name">
                              <div class="braintree-form__label">Cardholder Name</div>
                              <div class="braintree-form__field">
                                <div class="braintree-form-cardholder-name braintree-form__hosted-field">
                                  <iframe src="https://assets.braintreegateway.com/web/3.71.0/html/hosted-fields-frame.min.html#78b48574-5c5e-4342-8fb3-3e0a5cd540c1" frameborder="0" allowtransparency="true" scrolling="no" type="cardholderName" name="braintree-hosted-field-cardholderName" title="Secure Credit Card Frame - Cardholder Name" id="braintree-hosted-field-cardholderName" style="border: none; width: 100%; height: 100%; float: left;"></iframe>
                                  <div style="clear: both;"></div>
                                </div>
                                <div class="braintree-form__icon-container">
                                  <div class="braintree-form__icon braintree-form__field-error-icon">
                                    <svg width="24" height="24">
                                      <use xlink:href="#iconError"></use>
                                    </svg>
                                  </div>
                                </div>
                              </div>
                            </label>
                            <div data-braintree-id="cardholder-name-field-error" class="braintree-form__field-error"></div>
                          </div>
                          <div data-braintree-id="number-field-group" class="braintree-form__field-group">
                            <label>
                              <div class="braintree-form__label">Card Number</div>
                              <div class="braintree-form__field">
                                <div class="braintree-form-number braintree-form__hosted-field">
                                  <iframe src="https://assets.braintreegateway.com/web/3.71.0/html/hosted-fields-frame.min.html#78b48574-5c5e-4342-8fb3-3e0a5cd540c1" frameborder="0" allowtransparency="true" scrolling="no" type="number" name="braintree-hosted-field-number" title="Secure Credit Card Frame - Credit Card Number" id="braintree-hosted-field-number" style="border: none; width: 100%; height: 100%; float: left;"></iframe>
                                  <div style="clear: both;"></div>
                                </div>
                                <div class="braintree-form__icon-container">
                                  <div data-braintree-id="card-number-icon" class="braintree-form__icon braintree-form__field-secondary-icon">
                                    <svg width="40" height="24" class="braintree-icon--bordered">
                                      <use data-braintree-id="card-number-icon-svg" xlink:href="#iconCardFront"></use>
                                    </svg>
                                  </div>
                                  <div class="braintree-form__icon braintree-form__field-error-icon">
                                    <svg width="24" height="24">
                                      <use xlink:href="#iconError"></use>
                                    </svg>
                                  </div>
                                </div>
                              </div>
                            </label>
                            <div data-braintree-id="number-field-error" class="braintree-form__field-error"></div>
                          </div>
                          <div class="braintree-form__flexible-fields">
                            <div data-braintree-id="expiration-date-field-group" class="braintree-form__field-group">
                              <label>
                                <div class="braintree-form__label">Expiration Date <span class="braintree-form__descriptor">(MM/YY)</span> </div>
                                <div class="braintree-form__field">
                                  <div class="braintree-form__hosted-field braintree-form-expiration">
                                    <iframe src="https://assets.braintreegateway.com/web/3.71.0/html/hosted-fields-frame.min.html#78b48574-5c5e-4342-8fb3-3e0a5cd540c1" frameborder="0" allowtransparency="true" scrolling="no" type="expirationDate" name="braintree-hosted-field-expirationDate" title="Secure Credit Card Frame - Expiration Date" id="braintree-hosted-field-expirationDate" style="border: none; width: 100%; height: 100%; float: left;"></iframe>
                                    <div style="clear: both;"></div>
                                  </div>
                                  <div class="braintree-form__icon-container">
                                    <div class="braintree-form__icon braintree-form__field-error-icon">
                                      <svg width="24" height="24">
                                        <use xlink:href="#iconError"></use>
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                              </label>
                              <div data-braintree-id="expiration-date-field-error" class="braintree-form__field-error"></div>
                            </div>
                            <div data-braintree-id="cvv-field-group" class="braintree-form__field-group">
                              <label>
                                <div class="braintree-form__label">CVV <span data-braintree-id="cvv-label-descriptor" class="braintree-form__descriptor">(3 digits)</span> </div>
                                <div class="braintree-form__field">
                                  <div class="braintree-form__hosted-field braintree-form-cvv">
                                    <iframe src="https://assets.braintreegateway.com/web/3.71.0/html/hosted-fields-frame.min.html#78b48574-5c5e-4342-8fb3-3e0a5cd540c1" frameborder="0" allowtransparency="true" scrolling="no" type="cvv" name="braintree-hosted-field-cvv" title="Secure Credit Card Frame - CVV" id="braintree-hosted-field-cvv" style="border: none; width: 100%; height: 100%; float: left;"></iframe>
                                    <div style="clear: both;"></div>
                                  </div>
                                  <div class="braintree-form__icon-container">
                                    <div data-braintree-id="cvv-icon" class="braintree-form__icon braintree-form__field-secondary-icon">
                                      <svg width="40" height="24" class="braintree-icon--bordered">
                                        <use data-braintree-id="cvv-icon-svg" xlink:href="#iconCVVBack"></use>
                                      </svg>
                                    </div>
                                    <div class="braintree-form__icon braintree-form__field-error-icon">
                                      <svg width="24" height="24">
                                        <use xlink:href="#iconError"></use>
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                              </label>
                              <div data-braintree-id="cvv-field-error" class="braintree-form__field-error"></div>
                            </div>
                          </div>
                          <div data-braintree-id="save-card-field-group" class="braintree-form__field-group braintree-hidden">
                            <label>
                              <div class="braintree-form__field braintree-form__checkbox">
                                <input type="checkbox" data-braintree-id="save-card-input" checked=""> </div>
                              <div class="braintree-form__label">Save card</div>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div data-braintree-id="sheet-error" class="braintree-sheet__error">
                        <div class="braintree-form__icon braintree-sheet__error-icon">
                          <svg width="24" height="24">
                            <use xlink:href="#iconError"></use>
                          </svg>
                        </div>
                        <div data-braintree-id="sheet-error-text" class="braintree-sheet__error-text"></div>
                      </div>
                    </div>
                  </div>
                  <div data-braintree-id="lower-container" class="braintree-test-class braintree-options">
                    <div data-braintree-id="other-ways-to-pay" class="braintree-heading">Other ways to pay</div>
                  </div>
                  <div data-braintree-id="toggle" class="braintree-large-button braintree-toggle braintree-hidden" tabindex="0"> <span>Choose another way to pay</span> </div>
                </div>
                <div data-braintree-id="disable-wrapper" class="braintree-dropin__disabled braintree-hidden"></div>
            </div>
          </div>
          <div data-testid="billing_info_section">
            <div class="ms-TextField is-required PaymentInformation__StyledTextField-a2ybmj-1 ZckEP root-83">
              <div class="ms-TextField-wrapper">
                <label for="TextField86" id="TextFieldLabel88" class="ms-Label root-94">Street Address</label>
                <div class="ms-TextField-fieldGroup fieldGroup-84">
                  <input type="text" id="TextField86" aria-labelledby="TextFieldLabel88" name="billingAddressModel.streetAddress" required="" class="ms-TextField-field field-85" aria-invalid="false" value="">
                </div>
              </div>
            </div>
            <div class="PaymentInformation__FieldContainer-a2ybmj-2 SxeOl">
              <div class="ms-TextField is-required PaymentInformation__StyledTextField-a2ybmj-1 ZckEP root-83">
                <div class="ms-TextField-wrapper">
                  <label for="TextField89" id="TextFieldLabel91" class="ms-Label root-94">City</label>
                  <div class="ms-TextField-fieldGroup fieldGroup-84">
                    <input type="text" id="TextField89" aria-labelledby="TextFieldLabel91" name="billingAddressModel.city" required="" class="ms-TextField-field field-85" aria-invalid="false" value="">
                  </div>
                </div>
              </div>
              <div class="ms-TextField is-required PaymentInformation__StyledTextField-a2ybmj-1 ZckEP root-83">
                <div class="ms-TextField-wrapper">
                  <label for="TextField92" id="TextFieldLabel94" class="ms-Label root-94">State</label>
                  <div class="ms-TextField-fieldGroup fieldGroup-84">
                    <input type="text" id="TextField92" aria-labelledby="TextFieldLabel94" name="billingAddressModel.state" required="" class="ms-TextField-field field-85" aria-invalid="false" value="">
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div>
                <label id="Dropdown95-label">Country</label>
                <div data-is-focusable="true" id="Dropdown95" tabindex="0" role="listbox" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="Dropdown95-label Dropdown95-option" aria-required="true" aria-disabled="false" data-testid="country-dropdown" class="ms-Dropdown is-required dropdown-95"><span id="Dropdown95-option" class="ms-Dropdown-title ms-Dropdown-titleIsPlaceHolder title-96" aria-live="polite" aria-atomic="true" aria-invalid="false" role="option" aria-setsize="249">Select a Country</span><span class="ms-Dropdown-caretDownWrapper caretDownWrapper-97"><i data-icon-name="ChevronDown" aria-hidden="true" class="ms-Dropdown-caretDown caretDown-112"><div id="chevron-down-icon" data-testid="chevron-down-icon" height="16px" width="16px" class="Icon__IconDiv-h15f0s-0 kXmmZo"></div></i></span></div>
              </div>
              <div>
                <div>
                  <label>Zip Code</label>
                  <input type="text" name="zip-code" required />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div>Purchase Summary</div>
          <div>
            <div><span>$180</span><span>/Annually</span></div>
            <div>1,000 runs/Month</div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div>
        <div>
          <div>
            <div>All Plans Include</div>
            <ul>
              <li>Access to real browsers in real locations with the latest OS versions.</li>
              <li>Test on real connection speeds.</li>
              <li>Run page level and user journey tests including custom scripts.</li>
              <li>Access to test history for 13 months.</li>
              <li>Access to API integrations (Github Action, NodeJS wrapper, Slackbot and community-built integrations)</li>
              <li>Access to support and expert documentation.&nbsp;<a href="https://docs.webpagetest.org/api" target="_blank" rel="noopener">Learn More</a>.</li>
            </ul>
            <div>To learn more about <b>Custom Enterprise Plan</b>, please&nbsp;<a href="https://www.product.webpagetest.org/contact" target="_blank" rel="noopener noreferrer">Contact Us</a>.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
