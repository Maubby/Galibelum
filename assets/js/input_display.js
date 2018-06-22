$(document).ready(function(){
    // On Select option changed
    $(".activity").change(function(){
        // Check if current value is "Évènement eSport"
        if($(this).val() === "Évènement eSport"){
            // Security client view, input is required
            $(".activityInfo").prop('required',true);
            // Remove n/a value when you want to create an event
            $(".activityInfo").val("");
            // Show input field
            $(".activityInfo").show();
        }if($(this).val() === "Equipe eSport"){
            console.log('trouduc');
            // Security client view, input is required
            $(".activityInfo").prop('required',true);
            // Set n/a value when you want to create a team
            $(".activityInfo").val("n/a");
            // Hide input field
            $(".activityInfo").hide();
        }if($(this).val() === "Activité de streaming"){
            // Security client view, input is required
            $(".activityInfo").prop('required',true);
            // Set n/a value when you want to create an activity
            $(".activityInfo").val("n/a");
            // Hide input field
            $(".activityInfo").hide();
        }if($(this).val() === ""){
            // Security client view, input is required
            $(".activityInfos").prop('required',true);
            // Set n/a value
            $(".activityInfo").val("n/a");
            // Hide input field
            $(".activityInfo").hide();
        }
    });
});