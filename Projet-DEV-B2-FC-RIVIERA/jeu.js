document.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector("form");
    form.addEventListener("submit", function(event) {
        var match1Input = document.getElementById("match1");
        var match2Input = document.getElementById("match2");
        var match1Value = match1Input.value.trim();
        var match2Value = match2Input.value.trim();
        
        if (!isValidScore(match1Value) || !isValidScore(match2Value)) {
            alert("Veuillez saisir des scores valides pour les deux matchs.");
            event.preventDefault();
        }
    });
    
    function isValidScore(score) {
        return /^\d+-\d+$/.test(score); 
    }
});