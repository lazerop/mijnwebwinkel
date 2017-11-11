- omdat ik lokaal de CORS-problemen niet opgelost kreeg heb ik alle calls een GET gemaakt met data in de URL.... ik snap dat je zo geen password en username overstuurt.

- starten backend (dependency = Slim): cd webcart/public; php -S localhost:8080

- inloggen applicatie: 
	username: "ruud", password: "ruudshashedpw"
	username: "paul", password: "pw"
	username: "thirdperson", password: "NOGEENPW"

- gekozen voor een simpel inlog systeem omdat ik geen cookies wilde / kon zetten. Dus bij een refresh moet je opnieuw inloggen.


Nog proberen: serven index.html via Slim