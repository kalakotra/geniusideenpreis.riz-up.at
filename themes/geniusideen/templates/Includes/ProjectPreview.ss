<div class="card mb-3">
	<div class="card-header">
		<h2>Persönliche Daten</h2>
	</div>
	<div class="card-body bg-light">
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Anrede
			</div>
			<div class="col-12 col-lg-8">
				$Anrede
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Titel vorangestellt
			</div>
			<div class="col-12 col-lg-8">
				$AkademischerGrad
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Vorname 
			</div>
			<div class="col-12 col-lg-8">
				$Vorname
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Nachname 
			</div>
			<div class="col-12 col-lg-8">
				$Nachname
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Titel nachgestellt
			</div>
			<div class="col-12 col-lg-8">
				$AkademischerGradSufix
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Firma
			</div>
			<div class="col-12 col-lg-8">
				$Firma
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Abteilung
			</div>
			<div class="col-12 col-lg-8">
				$Abteilung
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Stra&szlig;e, Hausnummer 
			</div>
			<div class="col-12 col-lg-8">
				$Strasse
			</div>
		</div>


		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Postleitzahl 
			</div>
			<div class="col-12 col-lg-8">
				$PLZ
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Ort 
			</div>
			<div class="col-12 col-lg-8">
				$Ort
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Bezirk 
			</div>
			<div class="col-12 col-lg-8">
				$bezirkName($Bezirk)
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Telefon 
			</div>
			<div class="col-12 col-lg-8">
				$Vorwahl $Telefonnummer $Durchwahl
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Website
			</div>
			<div class="col-12 col-lg-8">
				$Website
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
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
		<h2>Ideen Daten</h2>
	</div>
	<div class="card-body bg-light">
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Titel der Idee 
			</div>
			<div class="col-12 col-lg-8">
				$IdeenTitle
			</div>
		</div>
		<div class="row align-items-center mb-1">
			<div class="col-12 col-lg-4">
				Kategorie 
			</div>
			<div class="col-12 col-lg-8">
				$Kategories.Title
			</div>
		</div>
		<div class="row mb-1">
			<div class="col-12 col-lg-4">
				Ideen-Kurz-Beschreibung
			</div>
			<div class="col-12 col-lg-8">
				$KurzBeschreibung
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
			<div class="row mb-1">
				<div class="col-12 col-lg-4">
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