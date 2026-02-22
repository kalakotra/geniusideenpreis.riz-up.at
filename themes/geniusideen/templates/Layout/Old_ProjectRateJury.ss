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

<form action="$Link/saveRatings" method="post" id="rateForm">
	<div class="lightBlue mb-3">
		<div class="container">
			<div class="row pt-2 pb-2">
				<div class="col-12">
					<h3 class="">Innovationsgrad</h3>
				</div>
				<div class="col-12 col-md-6">
					<span>
						Innovationsgrad
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							<div>
							<b>Für Produkt- und technische Prozeßinnovationen:</b><br />
							Gibt es Patente? Dokumentation des Neuheitsgrades, wissenschaftliche Befunde, Benchmarks, Referenzen
							Grundsätzliche technische Machbarkeit!! 
							</div><br />
							<div>
								<b>Für Dienstleistungen, Plattformen: </b><br />
								Bewertung von innovativen Elementen im Geschäftsmodell (Z.B. neue Absatzkanäle, innovative Dienstleistungen, Anwendung neuer wirtschaftswissenschaftlicher Erkenntnisse, Kombination von solchen Elementen)
							</div>
						" data-toggle="tooltip" data-html="true" />
					</span>
					<br />
					<textarea placeholder="Bewertungskommentar*" name="InnovationsKommentar" class="hideOnPrint">$me.myBewertung.InnovationsKommentar</textarea>
					<div class="showOnPrint">$me.myBewertung.InnovationsKommentar</div>
				</div>
				<div class="col-12 col-md-3">
					<span>
						Bewertung 
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							<b>Für Produkt- und technische Prozeßinnovationen:</b>
							<br /><b>1 Punkt</b> Stand der Technik oder keine techn. Innovation oder technisch nicht umsetzbar.
							<br /><b>2 Punkte</b> leichte Verbesserung durch Adaption/Kombination, weiterentwicklung von bestehenden Lösungen
							<br /><b>3 Punkte</b> Problemösung oder Produktinnovation durch intelligente Adaption/Kombination bestehenderTechnik(Erfindungen, neue Produkte, gute techn. Einfälle,..)
							<br /><b>4 Punkte</b> komplett neuer techn. Lösungsansatz, radikale technische Innovation, wissenschaftlicher Anspruch, Patentschutz (wenn patentierbar) veranlaßt
							<br /><br />
							<b>Für Dienstleistungen, Plattformen: </b><br />
							<b>1 Punkt</b> keine
							<br /><b>2 Punkte</b> Verbesserung von Bestehendem, Optimierung
							<br /><b>3 Punkte</b> Neue Geschäsftsidee im regionalen Bezug, oder Übernahme von Geschäftsmodellen aus anderen Branchen
							<br /><b>4 Punkte</b> neues Geschäftsmodell, radikal neuer Dienstleistungsansatz - auch überregional, international
						" data-toggle="tooltip" data-html="true" />
					</span>
					<select name="InnovationsBewertung" id="InnovationsBewertung" data-value="35" data-punkte="InnovationsPunkte">
						<option></option>
						<option <% if $me.myBewertung.InnovationsBewertung=1 %>selected<% end_if %>>1</option>
						<option <% if $me.myBewertung.InnovationsBewertung=2 %>selected<% end_if %>>2</option>
						<option <% if $me.myBewertung.InnovationsBewertung=3 %>selected<% end_if %>>3</option>
						<option <% if $me.myBewertung.InnovationsBewertung=4 %>selected<% end_if %>>4</option>
					</select>
					<span>Gew. 35%</span>
				</div>
				<div class="col-12 col-md-3">
					<span>Punkte gewichtet</span>
					<input type="text" name="InnovationsPunkte" id="InnovationsPunkte" readonly />
				</div>
			</div>
		</div>
	</div>

	<div class="mb-3">
		<div class="container">
			<div class="row pt-2 pb-2">
				<div class="col-12">
					<h3 class="">Kundennutzen, Marktpotenzial</h3>
				</div>
				<div class="col-12 col-md-6">
					<span>
						Kundennutzen, Marktpotenzial
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							Gibt es klare Alleinstellungsmerkmale (USP) für die Projektidee?<br />
							Zeigt sich ein entsprechendes Marktpotential?<br />
							Ist das Geschäftsmodell skalierbar, gibt es Wertschöpfungsaspekte?<br />
						"  data-toggle="tooltip" data-html="true" />
					</span>
					<textarea placeholder="Bewertungskommentar*"  name="MarktKommentar">$me.myBewertung.MarktKommentar</textarea>
					<div class="showOnPrint">$me.myBewertung.MarktKommentar</div>
				</div>
				<div class="col-12 col-md-3">
					<span>
						Bewertung
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							<b>1 Punkt</b> Kundennutzen unklar bzw. nicht nachvollziehbar, kein nennenswertes Marktpotential erkennbar<br />
							<b>2 Punkte</b> schwacher Kundennutzen oder nicht dokumentiert, begrenztes Marktpotential, kein Wachstum, keine Wertschöpfung<br />
							<b>3 Punkte</b> Kundennutzen vorhanden, dokumentiert bzw erkennbar. Zielmarkt ist vorhanden, auch ansatzweise dokumentiert <br />
							<b>4 Punkte</b> Highflyer, klarer Kundennutzen und Zielgruppen erkennbar, realistisches hohes Marktpotential in absehbarer Zukunft, Skalierbarkeit
						"  data-toggle="tooltip" data-html="true" />
					</span>
					<select name="MarktBewertung" id="MarktBewertung" data-value="35" data-punkte="MarktPunkte">
						<option></option>
						<option <% if $me.myBewertung.MarktBewertung=1 %>selected<% end_if %>>1</option>
						<option <% if $me.myBewertung.MarktBewertung=2 %>selected<% end_if %>>2</option>
						<option <% if $me.myBewertung.MarktBewertung=3 %>selected<% end_if %>>3</option>
						<option <% if $me.myBewertung.MarktBewertung=4 %>selected<% end_if %>>4</option>
					</select>
					<span>Gew. 35%</span>
				</div>
				<div class="col-12 col-md-3">
					<span>Punkte gewichtet</span>
					<input type="text" name="MarktPunkte" id="MarktPunkte" readonly />
				</div>
			</div>
		</div>
	</div>

	<div class="lightBlue mb-3">
		<div class="container">
			<div class="row pt-2 pb-2">
				<div class="col-12">
					<h3 >Umsetzungsrelevanz</h3>
				</div>
				<div class="col-12 col-md-6">
					<span>
						Umsetzungsrelevanz
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							<b>Für Produkt- und technische Prozeßinnovationen: </b><br />
							Ausmaß des verbleibenden technischen Entwicklungsrisikos<br /><br />
							<b>für Dienstleistungen, Plattformen: </b><br />
							Hat der Einreicher bzw. das Team die Möglichkeiten das Projekt umzusetzen?

						"  data-toggle="tooltip" data-html="true" />
					</span>
					<textarea placeholder="Bewertungskommentar*"  name="UmsetzungsrelevanzKommentar">$me.myBewertung.UmsetzungsrelevanzKommentar</textarea>
					<div class="showOnPrint">$me.myBewertung.UmsetzungsrelevanzKommentar</div>
				</div>
				<div class="col-12 col-md-3">
					<span>
						Bewertung
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							<b>Für Produkt- und technische Prozeßinnovationen: </b><br />
							<b>1 Punkt </b>Ideenpapier<br />
							<b>2 Punkte </b>Konstruktion, techn. Versuchsaufbau. Hohes verbleibendes technisches Entwicklungsrisiko<br />
							<b>3 Punkte </b>Prototyp (technische Probleme weitgehend gelöst, Prototyp weitestgehend Vorserientauglich), Marktumsetzung grplant<br />
							<b>4 Punkte </b>Produkt serienreif, techn. Prüfungen und Zertifizierungen bestanden, kein verbleibendes Entwicklungsrisiko, Vermarktung in Vorbereitung oder erfolgt<br />
							<br /><br />

							<b>für Dienstleistungen, Plattformen:</b><br />
							<b>1 Punkt </b>Ideenpapier<br />
							<b>2 Punkte </b>grundlegende Abläufe erkennbar, Geschäftsmodell plausibel, kann umgesetzt werden<br />
							<b>3 Punkte </b>DL/Geschäftsmodell klar beschrieben, wesentliche Voraussetzungen sind geschaffen (Ressourcen, Kooperationspartner, Programmierung erledigt), Rechtliche Rahmenbedingungen geklärt, Gründer(team)/Umsetzer sind vorhanden<br />
							<b>4 Punkte </b>Dienstleistung am Markt, gegebenfalls Zusatzservices und Zusatzdienstl. definiert <br />
							
						"  data-toggle="tooltip" data-html="true" />
					</span>
					<select name="UmsetzungsrelevanzBewertung" id="UmsetzungsrelevanzBewertung" data-value="20" data-punkte="UmsetzungsrelevanzPunkte">
						<option></option>
						<option <% if $me.myBewertung.UmsetzungsrelevanzBewertung=1 %>selected<% end_if %>>1</option>
						<option <% if $me.myBewertung.UmsetzungsrelevanzBewertung=2 %>selected<% end_if %>>2</option>
						<option <% if $me.myBewertung.UmsetzungsrelevanzBewertung=3 %>selected<% end_if %>>3</option>
						<option <% if $me.myBewertung.UmsetzungsrelevanzBewertung=4 %>selected<% end_if %>>4</option>
					</select>
					<span>Gew. 20%</span>
				</div>
				<div class="col-12 col-md-3">
					<span>Punkte gewichtet</span>
					<input type="text" name="UmsetzungsrelevanzPunkte" id="UmsetzungsrelevanzPunkte" readonly />
				</div>
			</div>
		</div>
	</div>

	<div class=" mb-3">
		<div class="container">
			<div class="row pt-2 pb-2">
				<div class="col-12">
					<h3>Wirtschafts- oder Gesellschaftspolitische Relevanz</h3>
				</div>
				<div class="col-12 col-md-6">
					<span>
						Wirtschafts- oder gesellschaftspolitische Relevanz
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							Ausmaß der regionalen Wertschöpfung, Beitrag zur Ökologischen- oder sozialen Zielen
						"  data-toggle="tooltip" data-html="true" />
					</span>
					<textarea placeholder="Bewertungskommentar*"  name="WirtschaftsrelevanzKommentar">$me.myBewertung.WirtschaftsrelevanzKommentar</textarea>
					<div class="showOnPrint">$me.myBewertung.WirtschaftsrelevanzKommentar</div>
				</div>
				<div class="col-12 col-md-3">
					<span>
						Bewertung
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							<b>1 Punkt </b>keine nennenswerte regionale Wertschöpfung, kaum Beitrag zur Ökologischen- oder sozialen Zielen<br />
							<b>2 Punkte </b>geringe regionale Wertschöpfung oder ledigleich Beitrag zu Ökologischen- oder sozialen Zielen<br />
							<b>3 Punkte </b>Projekte mit regionaler Wertschöpfung, eventuell kombiniert mit besonderem ökologischen, sozialen Impact<br />
							<b>4 Punkte </b>Leuchtturm/Vorzeigeprojekte, entsprechende regionale Wertschöpfung, extrem nachhaltig oder sozial innovativ, Projekte mit absolutem Storypotential<br />

						" data-toggle="tooltip" data-html="true" />
					</span>
					<select name="WirtschaftsrelevanzBewertung" id="WirtschaftsrelevanzBewertung" data-value="5" data-punkte="WirtschaftsrelevanzPunkte">
						<option></option>
						<option <% if $me.myBewertung.WirtschaftsrelevanzBewertung=1 %>selected<% end_if %>>1</option>
						<option <% if $me.myBewertung.WirtschaftsrelevanzBewertung=2 %>selected<% end_if %>>2</option>
						<option <% if $me.myBewertung.WirtschaftsrelevanzBewertung=3 %>selected<% end_if %>>3</option>
						<option <% if $me.myBewertung.WirtschaftsrelevanzBewertung=4 %>selected<% end_if %>>4</option>
					</select>
					<span>Gew. 5%</span>
				</div>
				<div class="col-12 col-md-3">
					<span>Punkte gewichtet</span>
					<input type="text" name="WirtschaftsrelevanzPunkte" id="WirtschaftsrelevanzPunkte" readonly />
				</div>
			</div>
		</div>
	</div>

	<div class="lightBlue mb-3">
		<div class="container">
			<div class="row pt-2 pb-2">
				<div class="col-12">
					<h3 >Qualit&auml;t der Einreichung, Ausma&szlig; der Dokumentation</h3>
				</div>
				<div class="col-12 col-md-6">
					<span>
						Qualit&auml;t der Einreichung, Ausma&szlig; der Dokumentation
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							<b>Bewertung der Qualität und des Ausmaßes der Einreichung</b>
							Wurden entsprechende Befunde (zB Technik, Patentsituation,) beigelegt oder muss Jury selbst recherchieren?
							Lesbarkeit, Verständlichkeit, Empfängerorientierung der Einreichung!
						" data-toggle="tooltip" data-html="true" />
					</span>
					<textarea placeholder="Bewertungskommentar*"  name="QualitatKommentar">$me.myBewertung.QualitatKommentar</textarea>
					<div class="showOnPrint">$me.myBewertung.QualitatKommentar</div>
				</div>
				<div class="col-12 col-md-3">
					<span>
						Bewertung
						<img src="$ThemeDir/images/info_icon.png" width="20" class=" infoIcon" title="
							<b>1 Punkt </b>Mindesteinreichstandard wurde gerade noch erfüllt, viele offene Fragen, keine Empfängerorientierung<br />
							<b>2 Punkte </b>grundsätzlich ausreichende Dokumentation, nicht besonders auf den Wettbewerb zugeschnittene Einreichung, wenig Empfängerorientierung<br />
							<b>3 Punkte </b>Projekt wurde ausreichend dokumentiert, keine Fragen sind offen<br />
							<b>4 Punkte </b>Umfangreiche Dokumentation, besonders ansprechende Optik und besondere Empfängerorientierung, zusätzliches Anschauungsmaterial (zB Video(links), Modelle, Präsentationen,..)<br />

						" data-toggle="tooltip" data-html="true" />
					</span>
					<select name="QualitatBewertung" id="QualitatBewertung" data-value="5" data-punkte="QualitatPunkte" readonly>
						<option></option>
						<option <% if $me.myBewertung.QualitatBewertung=1 %>selected<% end_if %>>1</option>
						<option <% if $me.myBewertung.QualitatBewertung=2 %>selected<% end_if %>>2</option>
						<option <% if $me.myBewertung.QualitatBewertung=3 %>selected<% end_if %>>3</option>
						<option <% if $me.myBewertung.QualitatBewertung=4 %>selected<% end_if %>>4</option>
					</select>
					<span>Gew. 5%</span>
				</div>
				<div class="col-12 col-md-3">
					<span>Punkte gewichtet</span>
					<input type="text" name="QualitatPunkte" id="QualitatPunkte" readonly />
				</div>
			</div>
		</div>
	</div>

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
					<textarea name="ProjektbezugKommentar">$me.myBewertung.ProjektbezugKommentar</textarea>
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
					<textarea name="GesamtKommentar" >$me.myBewertung.GesamtKommentar</textarea>
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