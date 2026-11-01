<div class="container">
	<div class="row">
		<div class="col-12 col-md-7 col-lg-8">
			<article>
				<div class="content hideOnPrint">$ProjectPreviewText</div>
				<div class="showOnPrint">Ihre Einreichung beim RIZ UP GENIUS Ideen- und Gründerpreis 2024</div>
	
				<% loop me %>
					<% include ProjectPreview %>
				<% end_loop %>
			</article>
		</div>
		<div class="col-12 cl-md-5 col-lg-4">
			<% if AnsprechPartner %>
				<% include SideBar %>
			<% end_if %>
		</div>
	</div>
</div>
<div class="formConfirmationHolder lightyellow pt-3 pb-3 hideOnPrint">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-none">
					<input type="checkbox" id="AktInfoCheckbox" checked="true" />
					Ja, ich möchte aktuelle Informationen zu den RIZ UP Services erhalten.
				</div>
				<div class="mb-3" id="agreeBox">
					<div>
						<input type="checkbox" id="bewertungCheckbox" />
						<label for="bewertungCheckbox">Ich bestätige, dass alle Angaben vollständig und bereit für die Bewertung durch die RIZ UP GENIUS Jury sind.</label>
					</div>
					
					<div>
						<input type="checkbox" id="informationenCheckbox" />
						<label for="informationenCheckbox">Ich bestätige, die folgenden Informationen gelesen und zur Kenntnis genommen zu haben:</label>
						<br /><br />
						<strong>Vertraulichkeit:</strong> Alle Daten, die Sie in unser System eingetragen haben, werden selbstverständlich streng vertraulich behandelt. Bei der Registrierung angegebene Kontakt- und Stammdaten werden ausschließlich in der RIZ UP Datenbank gespeichert und nur für die Jurybewertung, Kontaktaufnahme und Information im Rahmen des Wettbewerbs und des RIZ UP verwendet. Unsere Expertinnen und Experten verpflichten sich zur strengsten Geheimhaltung aller Daten, die sie im Rahmen ihrer RIZ UP GENIUS Juryverantwortung erhalten. 
						<br /><br />
						<strong>Auskunftsrecht und Widerruf:</strong> Wir erteilen Ihnen jederzeit Auskunft darüber, welche Daten wir über Sie gespeichert haben. Dazu senden Sie bitte eine E-Mail an genius@riz-up.at. Außerdem können Sie die Nutzung der persönlichen Daten jederzeit mit Wirkung für die Zukunft widerrufen. Dazu ist eine E-Mail an kontakt@riz-up.at zu senden. 
					</div>
				</div>
				<div id="systemButtons">
					<a data-href="$Link/projectAdded/" class="btn btn-outline-danger" id="finalSaveButton">Projekt einreichen</a>
					<a href="$Link" class="btn btn-secondary">Projekt bearbeiten</a>
					<a href="javascript:window.print();" class="btn btn-secondary">Drucken</a>
				</div>
			</div>
		</div>
	</div>
</div>