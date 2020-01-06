const form = document.querySelector('formrejestracja');
form.addEventListener('submit', function(e) {
    e.preventDefault(); //przerywamy domyślną wysyłkę

    const errors = []; //tablica błędów

    //tutaj przeprowadzamy różne testy pól
    if (danePoleJestBledne) {
        errors.push("Dane pole jest błędne");
    }
    if (innePoleJestBledne) {
        errors.push("Dane pole jest błędne");
    }

    //po wszystkich testach wysyłamy formularz lub pokazujemy błędy
    if (!errors.length) {
        this.submit();
    } else {
        alert("Wpisałeś błędne dane\n\n" + errors.join("\n"));
    }
});