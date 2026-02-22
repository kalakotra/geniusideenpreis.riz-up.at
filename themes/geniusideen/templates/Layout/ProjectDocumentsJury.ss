<div class="container">
	<div class="row">
		<div class="col-12 col-md-7- col-lg-8-">
			<div class="content">
				<a href="{$Link}/projectDetailsJury/$ID">< Zur&uuml;ck zur &Uuml;bersicht</a>
			</div>
			<div class="content">
				<h1>Projekt: $IdeenTitle</h1>
				<h3>Info hinzuf&uuml;gen</h3>
			</div>

			<div class="content documentUpload">
				<div>
					<br /><br />
					<strong>Dateienupload</strong><br />
					Sie k&ouml;nnen Textdokumente (PDF) hochladen. Diese sind dann auch f&uuml;r andere Jurymitglieder bei diesem Projekt sichtbar.<br />
					Bitte beachten Sie, dass die Dateigr&ouml;&szlig;e 5MB nicht &uuml;bersteigen sollte.
					<br /><br />
				</div>
				$documentsUploadForm

				<div class="row pt-1 pb-2">
					<% loop Document %>
						<div class="col-12 col-md-4 col-lg-3 pb-2">
							<a href="$Document.URL" target="_blank">$Document.Name</a>
							<div >
								$Description
							</div>
							<% if isOwner %>
								<a href="$Top.Link/deleteDocument/$ID" class="documentDeleteLink youSure" title="Information löschen"><img src="$ThemeDir/images/delete.png" /></a>
							<% end_if %>
						</div>
					<% end_loop %>
				</div>
			</div>
			<hr>
			<div class="content linkUpload">
				<div>
					<br /><br />
					<strong>Links</strong><br />
					Sie k&ouml;nnen Links hinzuf&uuml;gen. Diese sind dann auch f&uuml;r andere Jurymitglieder bei diesem Projekt sichtbar.
					<br /><br />
				</div>
				$juryLinksForm
				<div class="row pt-1 pb-2">
					<% loop JuryLink %>
						<div class="col-12 col-md-4 col-lg-3 pb-2">
							<a href="$URL" target="_blank">$Title</a>
							<div >
								$Description
							</div>
							<% if isOwner %>
								<a href="$Top.Link/deleteJuryLink/$ID" class="documentDeleteLink youSure" title="Information löschen"><img src="$ThemeDir/images/delete.png" /></a>
							<% end_if %>
						</div>
					<% end_loop %>
				</div>
			</div>

			<hr>
			<div class="content linkUpload">
				<div>
					<br /><br />
					<strong>Information für andere Juroren</strong><br />
					<br /><br />
				</div>
				$juryProjectInfoForm
			</div>
		</div>
	</div>
</div>