let translations = {};
let defaultLocale = window.localStorage.getItem("lang");
console.log(defaultLocale);
if (defaultLocale == null) {
    defaultLocale = "tr";
    window.localStorage.setItem("lang", "tr");
}

const fetchTranslations = async (newLocale) => {

    const response = await fetch(`../lang/${newLocale}.json`);

    if (!response.ok) {

        console.log(`Could not fetch translations for locale ${newLocale}`);

    }

    return await response.json();

};

function translatePage() {

    document.querySelectorAll('[localization-key]').forEach((element) => {

        let key = element.getAttribute('localization-key');

        let translation = translations[key];

        element.innerText = stringToHTML(translation);

    });

}

const setLocale = async (newLocale) => {

    translations = await fetchTranslations(newLocale);

    translatePage();

};

document.addEventListener('DOMContentLoaded', () => {

    setLocale(defaultLocale);

});

var switchLanguage = function (language) {
    if (defaultLocale !== language){
        document.querySelector(".language-option-selected").classList.remove("language-option-selected");

        document.querySelector(`#${language}`).classList.add("language-option-selected");


        defaultLocale = language;
        window.localStorage.setItem("lang", language);
    }
    
    setLocale(language);
}
// switcher.onchange = (e) => {


// };


var stringToHTML = function (str) {
	var parser = new DOMParser();
	var doc = parser.parseFromString(str, 'text/html');
	return doc.body.innerText;
};

var selectedOption = document.querySelector(`#${defaultLocale}`);

selectedOption.classList.add("language-option-selected");