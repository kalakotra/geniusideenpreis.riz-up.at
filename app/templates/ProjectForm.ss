<form $AttributesHTML>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	<fieldset>
		<% if $Legend %><legend>$Legend</legend><% end_if %>
		<% if $Fields.dataFieldByName(ProjectStep).value!="1" %>
		<div class="card mb-3">
			<div class="card-header">
				<h3>Persönliche Daten</h3>
			</div>
			<div class="card-body bg-light">
				<div class="row">
					<div class="col-12 col-lg-8">
						<span class="smallTextInForm">
							Bitte geben Sie Ihre persönlichen Daten ein.
						</span>
					</div>
					<div class="col-12 col-lg-4 text-right">
						<span class="smallTextInForm floatRight marginRight105">* Pflichtfeld</span>
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Anrede *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Anrede).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Titel vorangestellt
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(AkademischerGrad).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Vorname *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Vorname).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Nachname *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Nachname).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Titel nachgestellt
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(AkademischerGradSufix).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Firma
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Firma).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Abteilung
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Abteilung).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Stra&szlig;e, Hausnummer *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Strasse).FieldHolder
					</div>
				</div>


				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Postleitzahl *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(PLZ).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Ort *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Ort).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Bezirk *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Bezirk).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Telefon *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Telefonnummer).FieldHolder
						<div class="smallTextInForm">(bitte nur Zahlen eingeben)</div>
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Website
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Website).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						E-Mail *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Email).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12">
						<span class="smallTextInForm">Bitte geben Sie Ihre E-Mail-Adresse erneut ein.</span>
					</div>
					<div class="col-12 col-lg-4">
						E-Mail *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(Email2).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1 pt-4">
					<div class="col-12 col-lg-4-">
						Wie sind Sie auf den RIZ UP GENIUS aufmerksam geworden?
					</div>
					<div class="col-12 col-lg-8-">
						$Fields.dataFieldByName(WettbewerbAufmerksam).FieldHolder
					</div>
				</div>

			</div>
		</div>

		<div class="card mb-3">
			<div class="card-header">
				<h3>Ihre RIZ UP GENIUS Geschäftsidee</h3>
			</div>
			<div class="card-body bg-light">
				<div class="row align-items-center mb-1">
					<div class="col-12 col-lg-4">
						Titel der Idee *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(IdeenTitle).FieldHolder
					</div>
				</div>
				<div class="row align-items-center mb-1">
					<div class="col-12">
						<span class="smallTextInForm">Wir behalten uns vor, Einreichungen bei Bedarf in einer anderen Kategorie zu nominieren.</span>
					</div>
					<div class="col-12 col-lg-4">
						Kategorie *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(KategoriesID).FieldHolder
					</div>
				</div>
				<div class="row mb-1">
					<div class="col-12">
						<hr>
						<span class="smallTextInForm">Bitte beschreiben Sie die Idee in 3 S&auml;tzen (max 500 Zeichen).</span>
					</div>
					<div class="col-12 col-lg-4">
						Ideen-Kurz-Beschreibung (max. 3 S&auml;tze) *
					</div>
					<div class="col-12 col-lg-8">
						$Fields.dataFieldByName(KurzBeschreibung).FieldHolder
					</div>
				</div>
				
			</div>
		</div>

		<div class="card mb-3">
			<div class="card-header">
				<h3>Teammitglieder</h3>
				<span class="smallTextInForm">Bei Teamprojekten - bitte geben Sie die Namen aller Teammitglieder an:</span>
			</div>
			<div class="card-body bg-light">
				<% include TeamMemberBlock Anrede="Anrede1", AkademischerGrad="AkademischerGrad1", AkademischerGradSufix='AkademischerGrad1Sufix', Vorname='Vorname1', Nachname='Nachname1' %>
				<% include TeamMemberBlock Anrede="Anrede2", AkademischerGrad="AkademischerGrad2", AkademischerGradSufix='AkademischerGrad2Sufix', Vorname='Vorname2', Nachname='Nachname2' %>
				<% include TeamMemberBlock Anrede="Anrede3", AkademischerGrad="AkademischerGrad3", AkademischerGradSufix='AkademischerGrad3Sufix', Vorname='Vorname3', Nachname='Nachname3' %>
				<% include TeamMemberBlock Anrede="Anrede4", AkademischerGrad="AkademischerGrad4", AkademischerGradSufix='AkademischerGrad4Sufix', Vorname='Vorname4', Nachname='Nachname4' %>
				<% include TeamMemberBlock Anrede="Anrede5", AkademischerGrad="AkademischerGrad5", AkademischerGradSufix='AkademischerGrad5Sufix', Vorname='Vorname5', Nachname='Nachname5' %>

				<div class="<% if $Fields.dataFieldByName(OtherTeamMembers).value!='' %><% else %>teamMemberBlock<% end_if %>">
					<div class="row mb-1">
						<div class="col-12 col-lg-4">
							Alle weiteren Teammitglieder anführen
						</div>
						<div class="col-12 col-lg-8">
							$Fields.dataFieldByName(OtherTeamMembers).FieldHolder
						</div>
						<div class="col-12">
							Bitte erfassen Sie die weiteren TeilnehmerInnen mit Vor- und Nachnamen mit Beistrichen getrennt (Max Mustermann, Mara Musterfrau, ...)
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 text-right">
						<a id="formAddTeamMember" class="btn btn-warning">Weitere Teammitglieder erfassen</a>
					</div>
				</div>
			</div>
		</div>
		<% end_if %>
		<% if $Fields.dataFieldByName(ProjectStep).value!="0" %>
			<div class="card mb-3">
				<div class="card-header">
					<h3>Dateienupload</h3>
					<div class="card">	
						<div class="card-body bg-light">
							<strong>Bitte beachten Sie unbedingt die Dateigröße sowie das Dateiformat.<br />
							Sowohl die Ideen-Beschreibung als auch der Kurz-Lebenslauf sind Pflichtfelder!</strong>
						</div>
					</div>
				</div>
				<div class="card-body bg-light">
					<div class="row mb-1">
						<div class="col-12">
							<hr>
							<h3>Ideen-Beschreibung *</h3>
						</div>
						<div class="col-12">
							<span class="smallTextInForm">Unterlagen zur Idee mit Beantwortung der wichtigsten Fragen zu Innovationsgrad / Marktpotenzial / Nutzen für Kundinnen und Kunden / Realisierbarkeit.</span>
							<br />
							<span class="smallTextInForm fw-bold">Dateigröße: max. 5 MB pro Datei</span>
							<br />
							<span class="smallTextInForm fw-bold">Dateiformate: pdf, doc, docx, jpg, jpeg, gif, mp3, mp4, xls, xlsx, ppt, pptx, pps</span>
						</div>
						<div class="col-12">
							$Fields.dataFieldByName(Dokumente[]).FieldHolder
						</div>
						<div class="col-12">
							<% loop $Fields %>
								<% if Name='myDoc' %>
									$Field
								<% end_if %>
							<% end_loop %>
						</div>
					</div>
					<div class="row mb-1">
						<div class="col-12">
							<hr>
							<h3>Kurz-Lebenslauf *</h3>
						</div>
						<div class="col-12">
							<span class="smallTextInForm">Erforderlicher Inhalt: Angaben zur Person, Ausbildung, relevante Berufserfahrung, relevante Projekterfahrung, falls vorhanden: Publikationsliste bzw. Empfehlungen. <br />Laden Sie bei Teameinreichungen Kurz-Lebensläufe aller Teammitglieder hoch.</span>
							<br />
							<span class="smallTextInForm fw-bold">Dateigröße: max. 5 MB pro Datei</span>
							<br />
							<span class="smallTextInForm fw-bold">Dateiformate: pdf, doc, docx</span>
						</div>
						<div class="col-12">
							$Fields.dataFieldByName(Lebenslaufs[]).FieldHolder
						</div>
						<div class="col-12">
							<% loop $Fields %>
								<% if Name='myCvs' %>
									$Field
								<% end_if %>
							<% end_loop %>
						</div>
					</div>
				</div>
			</div>
		<% end_if %>
	</fieldset>
	$Fields.dataFieldByName(SecurityID)
	$Fields.dataFieldByName(ProjectID)
	$Fields.dataFieldByName(ProjectStep)
	
	<% if $Actions %>
		<div class="card mb-3 Actions">
			<div class="card-body bg-light-asfd">
				<div class="row align-items-end justify-content-end">
					<% if $Fields.dataFieldByName(ProjectStep).value!="1" %>
						<% loop $Actions %>
							<div class="col-12 pt-1 pb-1 text-right">
								$Field
							</div>
						<% end_loop %>
					<% else %>
						<% loop $Actions %>
							<% if Name='action_dosaveProjectFiles' %>
								<div class="d-none">$Field</div>
							<% else %>
								<div class="col-12 col-md-6- pt-1 pb-1 text-right">
									$Field
								</div>
							<% end_if %>
						<% end_loop %>
					<% end_if %>
				</div>
			</div>
		</div>
	<% end_if %>
</form>