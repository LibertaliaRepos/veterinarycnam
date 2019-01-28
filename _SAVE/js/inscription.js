                            ///////////////////////////////////////////////          
                            //                                           //
                            //          GESTION DES EVENEMENTS SUR       //
                            //          LE FORMULAIRE D'INSCRIPTION      //
                            //                                           //
                            ///////////////////////////////////////////////

var inscrForm = document.getElementById('sign-upForm');

var helpText = {
    help_Elt : null,
    DEBUG : false,
    
    init : function(textContent) {
        this.setHelp_Elt();
        this.help_Elt.textContent = textContent;
    },
    
    setHelp_Elt : function() {
        this.help_Elt = document.createElement('p');
        this.help_Elt.setAttribute('class', 'help-text cell');
        this.help_Elt.style.border = '1px solid red';
        this.help_Elt.style.fontWeight = 'bold';
        this.help_Elt.style.backgroundColor = 'rgba(250, 250, 250, 0.7)';
        this.help_Elt.style.color = '#cc4b37';
        this.help_Elt.style.fontSize = '0.9rem';
        this.help_Elt.style.padding = '1% 0 1% 5%';
    },
    
    setDEBUG : function(boolean) {
      this.DEBUG = boolean;  
    },
    
    setId : function(ident) {
      this.help_Elt.id = ident;  
    },
        
    toString : function() {
        if (this.help_Elt != null) {
            var div_Elt = document.createElement('div');
            div_Elt.appendChild(this.help_Elt);
            return div_Elt.innerHTML;
        } else {
            if (this.DEBUG) { return false; }
        }
    },
    getElement : function() {
        return this.help_Elt;
    }
}

if (inscrForm) {
    var mailISExists = document.querySelector('input[type=email][data-mail-exists]');
    var mailConfirm = document.getElementById('email2Sign');
    var passConfirm = document.getElementById('password2Sign');
    
    Listener(mailISExists, 'blur', testMailIsExists)
    Listener(mailConfirm, 'blur', mailTest);
    Listener(passConfirm, 'blur', passwordTest);
}