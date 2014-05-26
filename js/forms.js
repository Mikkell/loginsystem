function formhash(form, kode) {
    // Input til hashet kode.
    var p = document.createElement("input");
 
    // tilføj element til form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(kode.value);
 
    kode.value = "";
 
    // Send formen.
    form.submit();
}
 
function regformhash(form, uid, email, kode, conf) {
     // Tjek om alle felter er udfyldt.
    if (uid.value == ''         || 
          email.value == ''     || 
          kode.value == ''  || 
          conf.value == '') {
 
        alert('Du skal udfylde alle felter, før du kan gå videre.');
        return false;
    }
 
    // Tjek brugernavn.
 
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert('Brugernavn må kun indeholde bogstaver, tal og understregninger. Prøv igen.'); 
        form.brugernavn.focus();
        return false; 
    }
 
    // Tjek koden.
    if (kode.value.length < 6) {
        alert('Koden skal være mindst 6 cifre. Prøv igen.');
        form.kode.focus();
        return false;
    }
 
    // Eftertjek koden.
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(kode.value)) {
        alert('Koden skal indeholde mindst et tal, et lille bogstav og et stort bogstav. Prøv igen.');
        return false;
    }
 
    // Tjek at koderne stemmer overens.
    if (kode.value != conf.value) {
        alert('Koderne stemmer ikke overens. Prøv igen.');
        form.kode.focus();
        return false;
    }
 
    // Lav nyt input-element til den hashede kode.
    var p = document.createElement("input");
 
    // tilføj det nye element til formen.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(kode.value);
 
    // Bevar koden i feltet. 
    kode.value = "";
    conf.value = "";
 
    // Send formen.
    form.submit();
    return true;
}