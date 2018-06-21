$(document).ready(function(){
    // On Select option changed
    $(".activity").change(function(){
        // Check if current value is "Évènement eSport"
        if($(this).val() === "Évènement eSport"){
            // Show input field
            $(".activityInfo").show();   //This changes display to block
        }if($(this).val() === "Equipe eSport"){
            // Hide input field
            $(".activityInfo").hide();
        }if($(this).val() === "Activité de streaming"){
            // Hide input field
            $(".activityInfo").hide();
        }
    });
});