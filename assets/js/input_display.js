$(document).ready(function() {
    // On Select option changed
    $(".activity").change(function() {
        // Check if current value is "Évènement eSport"
        if($(this).val() === "Évènement eSport") {
            // Security client view, input is required
            $(".activityInfo").prop('required',true);
            // Security client view, input is required
            $(".activityAchievement").prop('required',true);
            // Remove n/a value when you want to create an event
            $(".activityInfo").val("");
            // Set n/a value when you want to create an event
            $(".activityAchievement").val("n/a");
            // Show input field
            $(".activityInfo").show();
            // Hide input field
            $(".activityAchievement").hide();
        }

        if($(this).val() === "Equipe eSport") {
            // Security client view, input is required
            $(".activityInfo").prop('required',true);
            // Security client view, input is required
            $(".activityAchievement").prop('required',true);
            // Set n/a value when you want to create a team
            $(".activityInfo").val("n/a");
            // Remove n/a value when you want to create a team
            $(".activityAchievement").val("");
            // Hide input field
            $(".activityInfo").hide();
            // Show input field
            $(".activityAchievement").show();
        }

        if($(this).val() === "Activité de streaming") {
            // Security client view, input is required
            $(".activityInfo").prop('required',true);
            // Security client view, input is required
            $(".activityAchievement").prop('required',true);
            // Set n/a value when you want to create an activity
            $(".activityInfo").val("n/a");
            $(".activityAchievement").val("n/a");
            // Hide input field
            $(".activityInfo").hide();
            $(".activityAchievement").hide();
        }

        if($(this).val() === "") {
            // Security client view, input is required
            $(".activityInfos").prop('required',true);
            // Security client view, input is required
            $(".activityAchievement").prop('required',true);
            // Set n/a value
            $(".activityInfo").val("n/a");
            $(".activityAchievement").val("n/a");
            // Hide input field
            $(".activityInfo").hide();
            $(".activityAchievement").hide();
        }
    });
});
