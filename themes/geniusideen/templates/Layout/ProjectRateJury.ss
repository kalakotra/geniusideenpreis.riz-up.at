<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="content">
				<a href="$Link">< Zur&uuml;ck zur &Uuml;bersicht</a>
				<h1>Projekt bewerten: $IdeenTitle</h1>
			</div>
		</div>
	</div>
</div>

<form action="$Link/saveRatings" method="post" id="rateForm" data-maxpoints="$getActiveCompetition.MaxPoints">
	<% loop getActiveCompetition.CompetitionCriteria %>
		<div class="my-3 <% if Odd %>lightBlue<% end_if %> CompetitionCriteriaHolder">
			<div class="container">
				<div class="row py-2">
					<div class="col-12">
						<h3 class="">$Title</h3>
					</div>
					<div class="col-12 col-md-6">
						<span>
							$Title
							<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
								$Description
							"  data-toggle="tooltip" data-html="true" />
						</span>
						<textarea placeholder="Bewertungskommentar*"  name="CriteriaKommentar[$ID]" >$getMemberBewertung.CriteriaKommentar</textarea>
						<div class="showOnPrint">$getMemberBewertung.CriteriaKommentar</div>
					</div>
					<div class="col-12 col-md-3">
						<span>
							Bewertung
							<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
								<b>1 Punkt ($Point1Title)</b> {$Point1Text}<br />
								<b>2 Punkte ($Point2Title)</b> {$Point2Text}<br />
								<b>3 Punkte ($Point3Title)</b> {$Point3Text}<br />
								<b>4 Punkte ($Point4Title)</b> {$Point4Text}
							"  data-toggle="tooltip" data-html="true" />
						</span>
						<select name="CriteriaPoints[$ID]" id="CriteriaPoints_$ID" class="CriteriaPoints" data-value="$PointWeight" data-inputfield="#CriteriaPointValue_$ID" >
							<option></option>
							<option <% if $getMemberBewertung.CriteriaBewertung=1 %>selected<% end_if %>>1</option>
							<option <% if $getMemberBewertung.CriteriaBewertung=2 %>selected<% end_if %>>2</option>
							<option <% if $getMemberBewertung.CriteriaBewertung=3 %>selected<% end_if %>>3</option>
							<option <% if $getMemberBewertung.CriteriaBewertung=4 %>selected<% end_if %>>4</option>
						</select>
						<span>Gew. {$PointWeight}%</span>
					</div>
					<div class="col-12 col-md-3">
						<span>Punkte gewichtet</span>
						<input type="text" name="CriteriaPointValue[$ID]" id="CriteriaPointValue_$ID" class="CriteriaPointValue" readonly />
					</div>
				</div>
			</div>
		</div>
	<% end_loop %>

	<div class="lightBlue2 mb-3">
		<div class="container">
			<div class="row pt-2 pb-2">
				<div class="col-12 col-md-6">
					<span>Ergebnis</span>
				</div>
				<div class="col-12 col-md-3">
					<span>Punkte gesamt</span>
					<input type="text" name="allPoints" id="allPoints" readonly />
				</div>
				<div class="col-12 col-md-3">
					<span>Punkte gewichtet</span>
					<input type="text" name="allPointsCalc" id="allPointsCalc" readonly />
				</div>
			</div>
			
		</div>
	</div>

	<div class=" mb-3">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-6">
					<span>Kommentar zu Projektbezug Nieder&ouml;sterreich *</span>
					<textarea name="ProjektbezugKommentar" class="commentarTextarea">$me.myBewertung.ProjektbezugKommentar</textarea>
					<div class="showOnPrint">$me.myBewertung.ProjektbezugKommentar</div>
				</div>
				<div class="col-12 col-md-6">
					<span>Gesamtkommentar * 
					<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							<strong>Bitte geben Sie uns aus Jurorensicht in 2-3 Sätzen</strong><br />
							a) eine Kurzfassung des eingereichten Projektes sowie<br />
							b) Ihr Fazit/Begründung für Ihre Bewertung ab.
						"  data-toggle="tooltip" data-html="true" />
					</span>
					<br />
					<textarea name="GesamtKommentar" class="commentarTextarea">$me.myBewertung.GesamtKommentar</textarea>
					<div class="showOnPrint">$me.myBewertung.GesamtKommentar</div>
				</div>
			</div>
		</div>
	</div>


	<div class="lightyellow mb-3 hideOnPrint">
		<div class="container pt-3 pb-3">
			<div class="row">
				<div class="col-12">
					<input type="submit" class="btn btn-primary" value="Speichern" />
					<a href="javascript:;" class="btn btn-secondary" id="rateFormUpdate">Veröffentlichen</a>
					<input type="hidden" name="rateFormUpdate" id="rateFormUpdateField" value="0" />
					<input type="hidden" name="projectID" value="$me.ID" />
					<input type="reset" class="btn btn-secondary" value="Abbrechen" />
					<a href="javascript:window.print();" class="btn btn-secondary">Drucken</a>
				</div>
			</div>
		</div>
	</div>

</form>