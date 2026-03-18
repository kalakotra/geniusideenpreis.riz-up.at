jQuery.noConflict();

(function($) {
	$(document).ready(function() {

		$('.youSure').click(function() {
			return window.confirm("Sind Sie sicher?");
		});

		$(window).on('load', function() {
			$(".teamMemberBlock").first().removeClass("teamMemberBlock");

			
			$('.infoIcon').tooltip();
		});

		$("#formAddTeamMember").click(function() {
			$(".teamMemberBlock").first().removeClass("teamMemberBlock");

			if ($(".teamMemberBlock").length == 0) {
				$(this).hide();
			} 
 		});

		$('#Form_myProjectUploadForm_Dokumente, #Form_myProjectUploadForm_Lebenslaufs').on("change",function() {
			$('#Form_myProjectUploadForm').submit();
		});

		$('#RegistrationForm_RegistrationForm_Dokumente, #RegistrationForm_RegistrationForm_Lebenslaufs, #RegistrationForm_RegistrationForm_Urkunde').on("change",function() {
			$('#RegistrationForm_RegistrationForm_action_doUploadProjectFiles_Step3').trigger("click");
		});

		$('.multiform-step .form-actions input[type="submit"]').addClass("btn btn-warning");

		// dont allow to go next if there is #RegistrationForm_RegistrationForm_forceError hidden field
		if ($('#RegistrationForm_RegistrationForm_forceError').length > 0) {
			// set disabled
			$('#RegistrationForm_RegistrationForm_action_next').attr("disabled", "disabled");
		}

		$('#RegistrationForm_RegistrationForm_IdeeGeschuetzt input').on("change", function() {
			if ($(this).val() == "1") {
				$('#RegistrationForm_RegistrationForm_Schutzart').attr("required", "required");
			} else {
				$('#RegistrationForm_RegistrationForm_Schutzart').removeAttr("required");
			}
		});

		$('#RegistrationForm_RegistrationForm_IdeeRealisiert input').on("change", function() {
			if ($(this).val() == "1") {
				$('#RegistrationForm_RegistrationForm_Umsetzungsgrad').attr("required", "required");
			} else {
				$('#RegistrationForm_RegistrationForm_Umsetzungsgrad').removeAttr("required");
			}
		});

		$('#RegistrationForm_RegistrationForm_Selbststaendig input').on("change", function() {
			if ($(this).val() == "1") {
				$('#RegistrationForm_RegistrationForm_SelbststaendigSeit').attr("required", "required");
			} else {
				$('#RegistrationForm_RegistrationForm_SelbststaendigSeit').removeAttr("required");
			}
		});

		$('#RegistrationForm_RegistrationForm_Wachstumsplanung input').on("change", function() {
			if ($(this).val() == "1") {
				$('#RegistrationForm_RegistrationForm_WachstumsplanungDetails').attr("required", "required");
			} else {
				$('#RegistrationForm_RegistrationForm_WachstumsplanungDetails').removeAttr("required");
			}
		});

		// Teammitglieder required fields onchange & onload
		$('#RegistrationForm_RegistrationForm_Teammitglieder').on("change", function() {
			$('#RegistrationForm_RegistrationForm_Vorname1, #RegistrationForm_RegistrationForm_Nachname1, #RegistrationForm_RegistrationForm_Vorname2, #RegistrationForm_RegistrationForm_Nachname2, #RegistrationForm_RegistrationForm_Vorname3, #RegistrationForm_RegistrationForm_Nachname3, #RegistrationForm_RegistrationForm_Vorname4, #RegistrationForm_RegistrationForm_Nachname4, #RegistrationForm_RegistrationForm_Vorname5, #RegistrationForm_RegistrationForm_Nachname5').removeAttr("required");
			if ($(this).val() > 0) {
				for (var i = 1; i <= $(this).val(); i++) {
					$('#RegistrationForm_RegistrationForm_Vorname' + i + ', #RegistrationForm_RegistrationForm_Nachname' + i).attr("required", "required");
				}
			}
		});
		$('#RegistrationForm_RegistrationForm_Teammitglieder').trigger("change");


 		/*$("#AktInfoCheckbox").on("change", function() {
			if ($("#agreeBox input:checked").length == 2) {
				if ($("#AktInfoCheckbox:checked").length == 1) {
					$("#finalSaveButton").attr("href", $("#finalSaveButton").attr("data-href") + "/ActuallInfo" );
				} else {
					$("#finalSaveButton").attr("href", $("#finalSaveButton").attr("data-href") );
				}
			}
		});*/

		$("#agreeBox input").on("change", function() {
			$myBtn = $("#finalSaveButton");
			if ($("#agreeBox input:checked").length == 2) {
				if ($("#AktInfoCheckbox:checked").length == 1) {
					$myBtn.attr("href", $myBtn.attr("data-href") + "/ActuallInfo");
				} else {
					$myBtn.attr("href", $myBtn.attr("data-href"));
				}
				$myBtn.addClass("btn-warning").removeClass("btn-outline-danger");
			} else {
				$myBtn.removeAttr("href");
				$myBtn.removeClass("btn-warning").addClass("btn-outline-danger");
			}
		});

		$("#finalSaveButton").click(function() {
			if ($(this).attr("href") !== undefined) {

			} else {
				alert("Kontrollkästen im gelben Bereich müssen aktiviert sein.");
			}
		});

		if ($("#projectListTable").length > 0) {
 			$("#projectListTable").DataTable({
				"paging": false,
				"language": {
		            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
		        }
			});
 		}


 		if ($("#rateForm").length > 0) {

			$('textarea').val(function(i,val) {
			    return $('<div>').html(val).text();
			});

			$("#rateForm select").trigger("change");

			$("#rateFormUpdate").click( function() {
				$("#rateFormUpdateField").val(1);
				$("#rateForm").submit();
				//$("#rateForm input[type=submit]").trigger("click");
			});
			var myMax = $("#rateForm").data("maxpoints");

			$("#rateForm select").change(function() {
	 			
	 			var myCriteriaWeight = $(this).data("value");
	 			var myPoints = ( ( myMax * myCriteriaWeight ) / 100 ) * ( $(this).val() / 4 );

	 			$($(this).data("inputfield")).val(myPoints.toFixed(2));

	 			refreshAllPoints();
	 		});

	 		function refreshAllPoints() {
	 			var sumAll = 0;
	 			var sumAllPunkte = 0;

	 			$(".CompetitionCriteriaHolder select").each(function() {
	 				//var myMax = $(this).data("maxpoints");
		 			var myCriteriaWeight = $(this).data("value");
		 			var myPoints = ( ( myMax * myCriteriaWeight ) / 100 ) * ( $(this).val() / 4 );

		 			sumAll = sumAll + 1 * $(this).val();
		 			sumAllPunkte = sumAllPunkte + myPoints
	 			});

	 			$("#allPoints").val(sumAll);
	 			$("#allPointsCalc").val((sumAllPunkte).toFixed(2));
	 			
	 		}
	 		
			$("#rateForm").submit(function () {
				var error = 0;
				var errorPoints = 0;

				if ($("#rateFormUpdateField").val() == 1) {
					$(".CompetitionCriteriaHolder textarea, .CompetitionCriteriaHolder select, .commentarTextarea").each(function() {
						if ($(this).val() == "") {
							$(this).addClass("requiredField");
							error = 1;
							if ($(this).prop('nodeName') == "SELECT") {
								errorPoints = 1;
							} else {
								error = 1;
							}
						} else {
							$(this).removeClass("requiredField");
						}
					});

					if (error == 1) {
						alert("Bitte füllen Sie alle mit * gekennzeichneten Pflichtfelder aus.");
					} else {
						if (errorPoints == 1) {
							alert("Bitte vergeben Sie bei allen Kategorien entsprechende Punkte");
						}
					}

					
				}

				if (error == 1 || errorPoints == 1) {

					$("#rateFormUpdateField").val(0);
					return false;

				} else {
					return true;
				}
			});
			

			$("#rateForm select").trigger("change");
		}
		
	});
}(jQuery));
