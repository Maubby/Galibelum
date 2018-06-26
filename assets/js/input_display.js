$(document).ready(function() {
    // On Select option changed
    $(".activity").change(function() {
        // Check if current value is "Évènement eSport"
        if($(this).val() === "Évènement eSport") {
            // Remove default date value when you want to create an event and Show input
            $(".activityDate").removeAttr("value").show();
            // Remove n/a value when you want to create an event and Show input
            $(".activityAddress").val("").show();
            // Set n/a value when you want to create an event and Hide input field
            $(".activityAchievement").hide();
        }

        if($(this).val() === "Equipe eSport") {
            // Set default date value when you want to create a team and Hide input
            $(".activityDate").attr("value","1993-07-07").hide();
            // Set n/a value when you want to create a team and Hide input
            $(".activityAddress").val("n/a").hide();
            // Remove n/a value when you want to create a team and Show input field
            $(".activityAchievement").show();
        }

        if($(this).val() === "Activité de streaming") {
            // Set default value date when you want to create an activity and Hide input
            $(".activityDate").attr("value","1993-07-07").hide();
            // Set n/a value when you want to create an activity and Hide input
            $(".activityAddress").val("n/a").hide();
            // Hide input field
            $(".activityAchievement").hide();
        }

        if($(this).val() === "") {
            // Set default value date when you want to create an activity and Hide input
            $(".activityDate").attr("value","1993-07-07").hide();
            // Set n/a value when you want to create a team and Hide input
            $(".activityAddress").val("n/a").hide();
            // Hide input field
            $(".activityAchievement").hide();
        }
    });
});
