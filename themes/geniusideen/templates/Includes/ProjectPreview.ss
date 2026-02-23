<div class="card mb-3">
	<div class="card-header">
		<h2>Persönliche Daten</h2>
	</div>
	<div class="card-body bg-light">
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4 font-weight-bold">
				Anrede
			</div>
			<div class="col-12 col-lg-8">
				$Anrede
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4 font-weight-bold">
				Titel vorangestellt
			</div>
			<div class="col-12 col-lg-8">
				$AkademischerGrad
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Vorname 
			</div>
			<div class="col-12 col-lg-8">
				$Vorname
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Nachname 
			</div>
			<div class="col-12 col-lg-8">
				$Nachname
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Titel nachgestellt
			</div>
			<div class="col-12 col-lg-8">
				$AkademischerGradSufix
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Firma
			</div>
			<div class="col-12 col-lg-8">
				$Firma
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Abteilung
			</div>
			<div class="col-12 col-lg-8">
				$Abteilung
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Stra&szlig;e, Hausnummer 
			</div>
			<div class="col-12 col-lg-8">
				$Strasse
			</div>
		</div>
		<hr />


		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Postleitzahl 
			</div>
			<div class="col-12 col-lg-8">
				$PLZ
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Ort 
			</div>
			<div class="col-12 col-lg-8">
				$Ort
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Bezirk 
			</div>
			<div class="col-12 col-lg-8">
				$bezirkName($Bezirk)
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Telefon 
			</div>
			<div class="col-12 col-lg-8">
				$Vorwahl $Telefonnummer $Durchwahl
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				Website
			</div>
			<div class="col-12 col-lg-8">
				$Website
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4  font-weight-bold">
				E-Mail 
			</div>
			<div class="col-12 col-lg-8">
				$Email
			</div>
		</div>
	</div>
</div>

<div class="card mb-3">
	<div class="card-header">
		<h2>Teammitglieder</h2>
	</div>
	<div class="card-body bg-light">
		<% include TeamMemberBlockPreview %>
		<% if OtherTeamMembers %>
			<hr />
			<h4 ><br />Weitere Teammitglieder</h4>
			<div class="row mb-1">
				<div class="col-12 col-lg-4 font-weight-bold">
					Alle weiteren Teammitglieder
				</div>
				<div class="col-12 col-lg-8">
					$OtherTeamMembers
				</div>
			</div>
		<% end_if %>
	</div>
</div>

<div class="card mb-3">
	<div class="card-header">
		<h2>Ihre RIZ UP GENIUS Geschäftsidee</h2>
	</div>
	<div class="card-body bg-light">
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4 font-weight-bold">
				Titel der Idee 
			</div>
			<div class="col-12 col-lg-8">
				$IdeenTitle
			</div>
		</div>
		<hr />
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4 font-weight-bold">
				Kategorie 
			</div>
			<div class="col-12 col-lg-8">
				$Kategories.Title
			</div>
		</div>
		<hr />
		<div class="row mb-1">
			<div class="col-12 col-lg-4- font-weight-bold">
				Ideen-Kurz-Beschreibung
			</div>
			<div class="col-12 col-lg-8-">
				$KurzBeschreibung
			</div>
		</div>

		<hr />
		<div class="row mb-1">
			<div class="col-12  font-weight-bold">
				Warum sollten Kunden bei Ihnen kaufen, was macht Ihre Idee einzigartig?
			</div>
			<div class="col-12 col-lg-8-">
				$WarumEinzigartig
			</div>
		</div>
		
		<hr />
		<div class="row mb-1">
			<div class="col-12  col-lg-4  font-weight-bold">
				Haben Sie die Idee geschützt?
			</div>
			<div class="col-12 col-lg-8">
				<% if $IdeeGeschuetzt=1 %>
					Ja
				<% else_if $IdeeGeschuetzt=0 %>
					Nein
				<% else %>
					im Laufen
				<% end_if %>
			</div>
		</div>
		<% if $IdeeGeschuetzt=1 && $Schutzart!='' %>
			<div class="row mb-1">
				<div class="col-12  col-lg-4  font-weight-bold">
					Schutzart
				</div>
				<div class="col-12 col-lg-8">
					$Schutzart
				</div>
			</div>
		<% end_if %>
		
		<hr />
		<div class="row mb-1">
			<div class="col-12  col-lg-4  font-weight-bold">
				Haben Sie Ihre Idee bereits umgesetzt/realisiert?
			</div>
			<div class="col-12 col-lg-8">
				<% if $IdeeRealisiert=1 %>
					Ja
				<% else %>
					Nein
				<% end_if %>
			</div>
		</div>
		<% if $IdeeRealisiert=1 && $Umsetzungsgrad!='' %>
			<div class="row mb-1">
				<div class="col-12  col-lg-4-  font-weight-bold">
					In welchem Stadium der Entwicklung stehen Sie mit Ihrer Geschäftsidee? Welche Schritte sind noch offen?
				</div>
				<div class="col-12 col-lg-8-">
					$Umsetzungsgrad
				</div>
			</div>
		<% end_if %>
		
		<hr />
		<div class="row mb-1">
			<div class="col-12  col-lg-4  font-weight-bold">
				Sind Sie bereits selbstständig?
			</div>
			<div class="col-12 col-lg-8">
				<% if $Selbststaendig=1 %>
					Ja
				<% else %>
					Nein
				<% end_if %>
			</div>
		</div>
		<% if $Selbststaendig=1 && $SelbststaendigSeit!='' %>
			<div class="row mb-1">
				<div class="col-12  col-lg-4  font-weight-bold">
					Seit
				</div>
				<div class="col-12 col-lg-8">
					$SelbststaendigSeit
				</div>
			</div>
		<% end_if %>
		
		<hr />
		<div class="row mb-1">
			<div class="col-12  col-lg-4-  font-weight-bold">
				Welche Zielgruppen spricht Ihre Geschäftsidee an?
			</div>
			<div class="col-12 col-lg-8-">
				$Zielgruppen
			</div>
		</div>
		
		<hr />
		<div class="row mb-1">
			<div class="col-12  col-lg-4-  font-weight-bold">
				Wie verdienen Sie Geld mit Ihrer Geschäftsidee?
			</div>
			<div class="col-12 col-lg-8-">
				$Einnahmequellen
			</div>
		</div>
		
		<hr />
		<div class="row mb-1">
			<div class="col-12  col-lg-4-  font-weight-bold">
				Welche Chancen und Risiken sehen Sie am (potenziellen) Markt?
			</div>
			<div class="col-12 col-lg-8-">
				$MarktChancenRisiken
			</div>
		</div>
		
		<hr />
		<div class="row mb-1">
			<div class="col-12  col-lg-4  font-weight-bold">
				Planen Sie mit dem Geschäftsmodell zu wachsen?
			</div>
			<div class="col-12 col-lg-8">
				<% if $Wachstumsplanung=1 %>
					Ja
				<% else %>
					Nein
				<% end_if %>
			</div>
		</div>
		
		<% if $Wachstumsplanung=1 && $WachstumsplanungDetails!='' %>
			<div class="row mb-1">
				<div class="col-12  col-lg-4-  font-weight-bold">
					Wie soll dieses Wachstum aussehen?
				</div>
				<div class="col-12 col-lg-8-">
					$WachstumsplanungDetails
				</div>
			</div>
		<% end_if %>
		
		<hr />
		<div class="row mb-1">
			<div class="col-12  col-lg-4-  font-weight-bold">
				Abschließend: Wir suchen innovative, niederösterreichische Geschäftsideen. Was ist der Mehrwert Ihrer Idee für Niederösterreich?
			</div>
			<div class="col-12 col-lg-8-">
				$MehrwertFuerNiederoesterreich
			</div>
		</div>
	</div>
</div>

<div class="card mb-3">
	<div class="card-header">
		<h3>Dateien</h3>
	</div>
	<div class="card-body bg-light">
		<div class="row mb-1">
			<div class="col-12 col-lg-4">
				Ideen-Beschreibung
			</div>
			<div class="col-12 col-lg-8">
				<% if Dokumente %>
					<% loop Dokumente %>
						<a href="$URL" target="_blank">$Name</a><br />
					<% end_loop %>
				<% end_if %>
			</div>
		</div>

		<div class="row mb-1">
			<div class="col-12 col-lg-4">
				Lebenslauf 
			</div>
			<div class="col-12 col-lg-8">
				<% if Lebenslaufs %>
					<% loop Lebenslaufs %>
						<a href="$URL" target="_blank">$Name</a><br />
					<% end_loop %>
				<% end_if %>
			</div>
		</div>
	</div>
</div>