<?php

	/**
	 * Classe représentant un courriel
	 * et qui permet de l'envoyer
	 */
	class Courriel {
		
		private $prenom;
		private $nom;
		private $de;
		private $sujet;
		private $message;
		private $a = "Frederic.Bouchard@fredeveloppe.com";
	
		/**
		 * Le constructeur du courriel
		 */
		function __construct($prenom, $nom, $de, $sujet, $message)
		{
		
			// Nous affectons nos variables d'instance
			// avec les valeurs que l'appelant nous
			// donne lors de la construction du courriel
			$this->prenom = $prenom;
			$this->nom = $nom;
			$this->de = $de;
			$this->sujet = $sujet;
			$this->message = $message;
		}
	
		/**
		 * Envoie le courriel
		 */		 
		public function envoyer(){
		
			// On construit les éléments de l'entête de notre courriel
			$headers = "Mine-Version: 1.0\r\n";
			$headers .= "Content-type: text/htm;charset=utf8\r\n";
			$headers .= "From: <$this->de>\r\n";
			
			// Retourne vrai si le courriel a été envoyé avec succès, sinon faux
			return mail($this->a, stripslashes(utf8_decode($this->sujet)), stripslashes(utf8_decode($this->message))."\n\n".stripslashes(utf8_decode($this->prenom))." ".stripslashes(utf8_decode($this->nom))." (".$this->de.")", $headers);

		}

		// Affiche le message
		public function show_mail()
		{
			return stripslashes(nl2br($this->message))."<br /><br />".stripslashes($this->prenom)." ".stripslashes($this->nom)." (".$this->de.")";
		}

		// Affiche le message de fallback
		public function mail_fallback()
		{
			return "Humm, c'est embarrassant...<br /><br />Le message que vous avez tenté de m'envoyer n'a pas pu être expédié. Cela est peut-être dû à une maintenance du serveur. Dans tous les cas, je suis sincèrement désolé du désagrément.<br /><br />Si le problème persiste, vous pouvez utiliser mon adresse personnelle <a href='mailto:frederic.bouchard@fredeveloppe.com'>frederic.bouchard@fredeveloppe.com</a>.<br /><br />Au plaisir d'avoir de vos nouvelles.<br /><br />Frédéric Bouchard";
		}
		
	}

?>