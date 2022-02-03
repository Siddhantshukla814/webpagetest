<script>
((window) => {
class Modal extends HTMLElement {
  constructor(){
    super();
    this._init = this._init.bind(this);
      this._observer = new MutationObserver(this._init);
  }
  connectedCallback(){
    if (this.children.length) {
      this._init();
    }
    this._observer.observe(this, { childList: true });
  }
  makeEvent( evtName ){
    if( typeof window.CustomEvent === "function" ){
      return new CustomEvent( evtName, {
        bubbles: true,
        cancelable: false
      });
    } else {
      var evt = document.createEvent('CustomEvent');
      evt.initCustomEvent( evtName, true, true, {} );
      return evt;
    }
  }
  _init(){
    this.closetext = "Close dialog";
    this.closeclass = "modal_close";
    this.closed = true;

    this.initEvent = this.makeEvent( "init" );
    this.beforeOpenEvent = this.makeEvent( "beforeopen" );
    this.openEvent = this.makeEvent( "open" );
    this.closeEvent = this.makeEvent( "close" );
    this.beforeCloseEvent = this.makeEvent( "beforeclose" );
    this.activeElem = document.activeElement;
    this.closeBtn = this.querySelector( "." + this.closeclass ) || this.appendCloseBtn();
    this.titleElem = this.querySelector( ".modal_title" );
    this.enhanceMarkup();
    this.bindEvents();
    this.dispatchEvent( this.initEvent );
  }
  closest(el, s){		
    var whichMatches = Element.prototype.matches || Element.prototype.msMatchesSelector;
      do {
        if (whichMatches.call(el, s)) return el;
        el = el.parentElement || el.parentNode;
      } while (el !== null && el.nodeType === 1);
      return null;
  }
  appendCloseBtn(){
    var btn = document.createElement( "button" );
    btn.className = this.closeclass;
    btn.innerHTML = this.closetext;
    this.appendChild(btn);
    return btn;
  }

  enhanceMarkup(){
    this.setAttribute( "role", "dialog" );
    this.id = this.id || ("modal_" + new Date().getTime());
    if( this.titleElem ){
      this.titleElem.id = this.titleElem.id || ("modal_title_" + new Date().getTime());
      this.setAttribute( "aria-labelledby", this.titleElem.id );
    }
    this.classList.add("modal");
    this.setAttribute("tabindex","-1");
    this.overlay = document.createElement("div");
    this.overlay.className = "modal_screen";
    this.parentNode.insertBefore(this.overlay, this.nextSibling);
    this.modalLinks = "a.modal_link[href='#" + this.id + "']";
    this.changeAssocLinkRoles();
  }

  addInert(){
    var self = this;
    function inertSiblings( node ){
      if( node.parentNode ){
        for(var i in node.parentNode.childNodes ){
          var elem = node.parentNode.childNodes[i];
          if( elem !== node && elem.nodeType === 1 && elem !== self.overlay ){
            elem.inert = true;
          }
        }
        if( node.parentNode !== document.body ){
          inertSiblings(node.parentNode);
        }
      }

    }
    inertSiblings(this);
  }

  removeInert(){
    var elems = document.querySelectorAll( "[inert]" );
    for( var i = 0; i < elems.length; i++ ){
      elems[i].inert = false;
    }
  }

  open( programmedOpen ){
    this.dispatchEvent( this.beforeOpenEvent );
    this.classList.add( "modal-open" );
    if( !programmedOpen ){
      this.focusedElem = this.activeElem;
    }
    this.closed = false;
    this.focus();
    this.addInert();
    this.dispatchEvent( this.openEvent );
  }



  close( programmedClose ){
    var self = this;
    this.dispatchEvent( this.beforeCloseEvent );
    this.classList.remove( "modal-open" );
    this.closed = true;
    self.removeInert();
    var focusedElemModal = self.closest(this.focusedElem, ".modal");
    if( focusedElemModal ){
      focusedElemModal.open( true );
    }
    if( !programmedClose ){
      this.focusedElem.focus();
    }

    this.dispatchEvent( this.closeEvent );
  }

  changeAssocLinkRoles(){
    var elems = document.querySelectorAll(this.modalLinks);
    for( var i = 0; i < elems.length; i++ ){
      elems[i].setAttribute("role", "button" );
    }
  }


  bindEvents(){
    var self = this;

    // close btn click
    this.closeBtn.addEventListener('click', event => self.close());

    // open dialog if click is on link to dialog
    window.addEventListener('click', function( e ){
      var assocLink = self.closest(e.target, self.modalLinks);
      if( assocLink ){
        e.preventDefault();
        self.open();
      }
    });

    window.addEventListener('keydown', function( e ){
      var assocLink = self.closest(e.target, self.modalLinks);
      if( assocLink && e.keyCode === 32 ){
        e.preventDefault();
        self.open();
      }
    });

    window.addEventListener('focusin', function( e ){
      self.activeElem = e.target;
    });

    // click on the screen itself closes it
    this.overlay.addEventListener('mouseup', function( e ){
      if( !self.closed ){
        self.close();
      }
    });

    // click on anything outside dialog closes it too (if screen is not shown maybe?)
    window.addEventListener('mouseup', function( e ){
      if( !self.closed && !self.closest(e.target, "#" + self.id ) ){
        e.preventDefault();
        self.close();
      }
    });


    // close on escape
    window.addEventListener('keydown', function( e){
      if( e.keyCode === 27 &&  !self.closed ){
        e.preventDefault();
        self.close();
      }

    });

    // close on other dialog open
    window.addEventListener('beforeopen', function( e){
      if( !self.closed && e.target !== this ){
        self.close( true );
      }
    });
  }

  disconnectedCallback(){
    this._observer.disconnect();
    // remove screen when elem is removed
    this.overlay.remove();
  }
}

if ('customElements' in window) {
  customElements.define('fg-modal', Modal );
}

window.Modal = Modal;

})(window);

</script>
<style>
.fg-modal * {
  box-sizing: border-box;
}

.fg-modal fieldset {
  border: 0;
}

.fg-modal legend {
  font-size: 1.875rem;
}

.fg-modal .required::after {
  color: red;
  content: '*';
}

.fg-modal .save-button button {
  background-color: #2c97ff;
  border-radius: 2px;
  appearance: none;
  border: 1px solid rgb(0, 120, 212);
  color: white;
  font-size: 13px;
  height: 30px;
  padding: 0 17px;
}

.fg-modal label {
  display: block;
}

.fg-modal .section:first-child {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.fg-modal .section:not(:first-child),
.fg-modal .save-button {
  margin-top: 1.25rem;
}

.fg-modal input {
  max-width: none;
  width: 100%;
  border: 1px solid;
  border-radius: 2px;
  font-size: 1em;
  padding: 0.6875em 1.3125em;
}

.fg-modal input:invalid {
  outline: 1px solid red;
}

.fg-modal input:invalid::after {
  display: block;
  content: 'Hi what are you doing?';
}

.fg-modal .details {
  margin-top: 1rem;
  font-size: 0.75rem;
  font-weight: 400;
  color: rgb(102, 102, 102);
}

body.theme-b {
  background: rgb(234, 234, 234);
}
.my-account-page {
  margin: 0 auto;
  width: 72%;
}

.subhed, .card {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

.subhed {
  align-items: center;
}

.contact-support-button a {
  display: flex;
  align-items: center;
  flex-direction: row;
  justify-content: space-between;
  color: rgb(43, 148, 255);
  text-decoration: none;
}

.contact-support-button a::before {
  width: 20px;
  height: 20px;
  margin-right: 5px;
  content: '';
  background: url("data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4NCjxwYXRoIGQ9Ik0zLjUgOEMzLjUgNC40MTAxNSA2LjQxMDE1IDEuNSAxMCAxLjVDMTMuNTg5OSAxLjUgMTYuNSA0LjQxMDE1IDE2LjUgOEMxNS45NDc3IDggMTUuNSA4LjQ0NzcxIDE1LjUgOVYxMkMxNS41IDEyLjUzNjUgMTUuOTIyNiAxMi45NzQ0IDE2LjQ1MyAxMi45OTg5QzE2LjMxMTEgMTQuNDQzMSAxNS44NDg1IDE1LjU4NjYgMTUuMDc0IDE2LjQwNjdDMTQuMzQ5MiAxNy4xNzQxIDEzLjMwNjkgMTcuNzA1IDExLjg3ODcgMTcuOTA4MkMxMS42NDkxIDE3LjM3NCAxMS4xMTgzIDE3IDEwLjUgMTdIOS41QzguNjcxNTcgMTcgOCAxNy42NzE2IDggMTguNUM4IDE5LjMyODQgOC42NzE1NyAyMCA5LjUgMjBIMTAuNUMxMS4xODY5IDIwIDExLjc2NTkgMTkuNTM4MyAxMS45NDM3IDE4LjkwODRDMTMuNTgzNyAxOC42ODg2IDE0Ljg3MzQgMTguMDc1NSAxNS44MDEgMTcuMDkzM0MxNi43ODY1IDE2LjA0OTkgMTcuMzExMSAxNC42NDQ5IDE3LjQ1NzEgMTNIMTcuNUMxOC42MDQ2IDEzIDE5LjUgMTIuMTA0NiAxOS41IDExVjEwQzE5LjUgOC44OTU0MyAxOC42MDQ2IDggMTcuNSA4QzE3LjUgMy44NTc4NiAxNC4xNDIxIDAuNSAxMCAwLjVDNS44NTc4NiAwLjUgMi41IDMuODU3ODYgMi41IDhDMS4zOTU0MyA4IDAuNSA4Ljg5NTQzIDAuNSAxMFYxMUMwLjUgMTIuMTA0NiAxLjM5NTQzIDEzIDIuNSAxM0gzLjVDNC4wNTIyOCAxMyA0LjUgMTIuNTUyMyA0LjUgMTJWOUM0LjUgOC40NDc3MiA0LjA1MjI4IDggMy41IDhaIiBmaWxsPSIjMkY4MEVEIi8+DQo8L3N2Zz4NCg==") center center no-repeat;
}

.card {
  align-items: flex-start;
  background-color: rgb(255, 255, 255);
  margin-bottom: 30px;
  padding: 30px;
  border-radius: 10px;
  box-shadow: rgb(0 0 0 / 10%) 1px 1px 4px 0px;
}

.edit-button button {
  position: relative;
  padding: 8px;
  cursor: pointer;
  appearance: none;
  border: 0;
  background-color: inherit;
  background: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4NCjxwYXRoIGQ9Ik0xNSAyTDMgMTRMMiAxOEw2IDE3TDE4IDVMMTUgMlpNMTUgMy40MUwxNi41OSA1TDE0LjY1IDYuOTRMMTMuMDYgNS4zNUwxNSAzLjQxWk01LjQ5IDE2LjFMMy4zNyAxNi42M0wzLjkgMTQuNTFMNS4zNiAxMy4wNkw2Ljk1IDE0LjY1TDUuNDkgMTYuMVpNNy42NSAxMy45NEw2LjA2IDEyLjM1TDEyLjM1IDYuMDZMMTMuOTQgNy42NUw3LjY1IDEzLjk0WiIgZmlsbD0iIzAwNkFENCIvPg0KPC9zdmc+DQo=);
  background-position: 50%;
}

.edit-button button span {
  clip: rect(1px, 1px, 1px, 1px);
  clip-path: inset(50%);
  height: 1px;
  width: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
}

.subscription-plan strong {
  font-weight: normal;
}

.subscription-plan strong::after {
  content: ':';
}

.billing-history {
  display: block;
}

.modal,
.modal_screen {
  position: fixed;
  z-index: 1000;
}

.modal_screen {
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  bottom: 0;
  right: 0;
  background: rgba(0, 0, 0, .5);
  display: none;
}
.modal {
  visibility: hidden;
}
.modal-open {
  visibility: visible;
}
.modal-open + .modal_screen {
  display: block
}

.modal-open {
  z-index: 1001;
  background: rgb(244, 244, 244);
  box-sizing: border-box;
  padding: 5vh;
  top: 10vh;
  left: 10vw;
  height: 80vh;
  width: 80vw;
  overflow: auto;
  border-radius: 10px;
  box-shadow: rgb(0 0 0 / 22%) 0px 25.6px 57.6px 0px, rgb(0 0 0 / 18%) 0px 4.8px 14.4px 0px;
}

.modal_close {
  position: absolute;
  top: 1vh;
  right: 1vh;
  border: none;
  cursor: pointer;
  background: transparent;
  margin: 0;
  font-size: 1.4rem;
  width: 1.4em;
  height: 1.4em;
  line-height: 1;
  overflow: hidden;
  text-indent: -999px;
}
.modal_close:before,
.modal_close:after {
  content: "";
  height: 1em;
  width: .1em;
  top: .2em;
  left: .65em;
  background: #777;
  position: absolute;
  transform: rotate(-45deg);
}
.modal_close:after {
  transform: rotate(45deg);
}


/* inert polyfill styles */
[inert] {
  pointer-events: none;
  cursor: default;
}

[inert],
[inert] * {
  user-select: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
}
</style>
<div class="my-account-page">
  <div class="subhed">
    <h1>My Account</h1>
    <?php if ($is_paid) { ?>
    <div class="contact-support-button">
      <a href="https://support.webpagetest.org"><span>Contact Support</span></a>
    </div>
    <?php } ?>
  </div>

  <div>
    <div class="card contact-info" data-modal="contact-info-modal">
      <div class="card-section">
        <h3><?php echo htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name); ?></h3>
        <div class="info">
          <div><?php echo htmlspecialchars($email); ?></div>
        </div>
      </div>
      <div class="card-section">
        <div class="edit-button">
          <button><span>Edit</span></button>
        </div>
      </div>
    </div>

    <div class="card password" data-modal="password-modal">
      <div class="card-section">
        <h3>Password</h3>
        <div class="info">
          <div>************</div>
        </div>
      </div>
      <div class="card-section">
        <div class="edit-button">
          <button><span>Edit</span></button>
        </div>
      </div>
    </div>

<?php if ($is_paid) {
  include_once __DIR__ . '/includes/signup.php';
} else {
  include_once __DIR__ . '/includes/billing-data.php';
} ?>
</div>


<?php
include_once __DIR__ . '/includes/modals/contact-info.php';
include_once __DIR__ . '/includes/modals/password.php';

?>



<fg-modal id="subscription-plan-modal" class="subscription-plan-modal fg-modal">
  <form method="POST" action="/account">
    <fieldset>
      <legend class="modal_title">Subscription Details</legend>
    </fieldset>
  </form>
</fg-modal>

<fg-modal id="subscription-plan-modal" class="subscription-plan-modal fg-modal">
  <form method="POST" action="/account">
    <fieldset>
      <legend class="modal_title">Subscription Details</legend>
    </fieldset>
  </form>
</fg-modal>

<fg-modal id="payment-info-modal" class="payment-info-modal fg-modal">
  <form method="POST" action="/account">
    <fieldset>
      <legend class="modal_title">Payment Information</legend>
    </fieldset>
  </form>
</fg-modal>

<script>
(() => {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.edit-button button').forEach(el => {
        el.addEventListener('click', (e) => {
          const card = e.target.closest('[data-modal]');
          const modal = card.dataset.modal;
          document.querySelector(`#${modal}`).open();
        });
      });
    });
  } else {
    document.querySelectorAll('.edit-button button').forEach(el => {
      el.addEventListener('click', (e) => {
        const card = e.target.closest('[data-modal]');
        const modal = card.dataset.modal;
        document.querySelector(`#${modal}`).open();
      });
    });
  }
})();
</script>
