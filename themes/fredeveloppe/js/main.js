var compteur = 0,
	ecussonFront,
	userLoginForm;

jQuery(function($)
{
	// Ajoute dynamiquement un ruban au visuel du menu
	$(".region-menu .menu .active").parent().prepend("<span class='ribbon'><span class='left'></span><span class='right'></span></span>");

	// Fonction de retour en haut de page
	$("#haut-page").click("a", function(e)
	{
		e.preventDefault();
		$('html, body').animate({scrollTop:0},1000);
	});

	// Fais bouger l'écusson de Fredeveloppe
	ecussonFront = $("#ecusson-front");
	userLoginForm = $("#user-login-form"); 

	$("#vis").css("cursor","pointer").toggle(function()
	{
		ecussonFront.css("z-index","10").rotateMain({animateTo: 180, duration: 5000, easing: $.easing.easeOutElastic, callback: function(){return false;}});
		compteur++;
		waiting_clock = setTimeout("verifier_index_connexion()", 1000);
	}, function()
	{
		clearInterval(waiting_clock);
		compteur++;
		verifier_index_connexion();

		ecussonFront.stop(true).rotateMain({animateTo: 0, duration: 1500, easing: $.easing.easeOutQuad, callback: function()
			{
				$(this).css("z-index","2");
			}
		});
	});

	// Démarre le tooltip spécial sur tous les éléments avec un title
	$("[title]").each(function()
	{
		var node = this;

		$(node).qtip({
			style: {
		        classes: "qtip-light qtip-rounded qtip-shadow"
		    },
	        content: this.title,
	        position: {
	            target: 'mouse',
	            adjust: { x: 15, y: 30 },
	            viewport: $(window)
	        }
    	});
	});
});

// Fonction qui permet de superposer les éléments à chaque déclanchement de l'écusson
function verifier_index_connexion()
{
	if(compteur % 2 == 0)
	{
		userLoginForm .css("z-index","1");
	}
	else
	{
		userLoginForm .css("z-index","10");		
	}
}

// Simulate localStorage if not compatible
if (!window.localStorage) {
  Object.defineProperty(window, "localStorage", new (function () {
    var aKeys = [], oStorage = {};
    Object.defineProperty(oStorage, "getItem", {
      value: function (sKey) { return sKey ? this[sKey] : null; },
      writable: false,
      configurable: false,
      enumerable: false
    });
    Object.defineProperty(oStorage, "key", {
      value: function (nKeyId) { return aKeys[nKeyId]; },
      writable: false,
      configurable: false,
      enumerable: false
    });
    Object.defineProperty(oStorage, "setItem", {
      value: function (sKey, sValue) {
        if(!sKey) { return; }
        document.cookie = escape(sKey) + "=" + escape(sValue) + "; expires=Tue, 19 Jan 2038 03:14:07 GMT; path=/";
      },
      writable: false,
      configurable: false,
      enumerable: false
    });
    Object.defineProperty(oStorage, "length", {
      get: function () { return aKeys.length; },
      configurable: false,
      enumerable: false
    });
    Object.defineProperty(oStorage, "removeItem", {
      value: function (sKey) {
        if(!sKey) { return; }
        document.cookie = escape(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
      },
      writable: false,
      configurable: false,
      enumerable: false
    });
    this.get = function () {
      var iThisIndx;
      for (var sKey in oStorage) {
        iThisIndx = aKeys.indexOf(sKey);
        if (iThisIndx === -1) { oStorage.setItem(sKey, oStorage[sKey]); }
        else { aKeys.splice(iThisIndx, 1); }
        delete oStorage[sKey];
      }
      for (aKeys; aKeys.length > 0; aKeys.splice(0, 1)) { oStorage.removeItem(aKeys[0]); }
      for (var aCouple, iKey, nIdx = 0, aCouples = document.cookie.split(/\s*;\s*/); nIdx < aCouples.length; nIdx++) {
        aCouple = aCouples[nIdx].split(/\s*=\s*/);
        if (aCouple.length > 1) {
          oStorage[iKey = unescape(aCouple[0])] = unescape(aCouple[1]);
          aKeys.push(iKey);
        }
      }
      return oStorage;
    };
    this.configurable = false;
    this.enumerable = true;
  })());
}