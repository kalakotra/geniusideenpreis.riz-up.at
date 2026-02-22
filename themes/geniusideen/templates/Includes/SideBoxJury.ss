<aside>
	<% loop me %>
		<div class="contactPersonWidget lightBlue">
			<h3 class="headline rizblue">Weitere Informationen</h3>
			<div class="widgetTexts">
				<div class="widgetDetailTitle">Einreichdatum</div>
				$Created.Format("d.M.Y")
				<br class="clear" />
				<div class="widgetDetailTitle">Status</div> $getJuryStatusForFrontend
			</div>
			<% if AdminKomentarExt %>
				<div class="widgetTexts">
					<strong>Admin Kommentar:</strong><br />
					$AdminKomentarExt
				</div>
			<% end_if %>
		</div>

		<div class="contactPersonWidget lightBlue mt-4">
			<h3 class="headline rizblue">Infos von Jurymitgliedern</h3>
			<div class="widgetTexts">
				<div class="projectJuryDocuments">
					<% loop Document %>
						<div class="documentBlock">
							<img src="$ThemeDir/images/info_icon.png" title="$Member.Name"/>
							<a href="$Document.URL" target="_blank">$Document.Name</a>
							<div >
								$Description
							</div>
							<% if isOwner %>
								<a href="$Top.Link/deleteDocument/$ID" class="documentDeleteLink youSure hideJuryLink"  title="Information löschen"><img src="$ThemeDir/images/delete.png" /></a>
							<% end_if %>
						</div>
					<% end_loop %>
				</div>
				<hr />
				<div class="projectJuryDocuments">
					<% loop JuryLink %>
						<div class="documentBlock">
							<img src="$ThemeDir/images/info_icon.png" title="$Member.Name"/>
							<a href="$URL" target="_blank">$Title</a>
							<div >
								$Description
							</div>
							<% if isOwner %>
								<a href="$Top.Link/deleteJuryLink/$ID" class="documentDeleteLink youSure hideJuryLink" title="Information löschen"><img src="$ThemeDir/images/delete.png" /></a>
							<% end_if %>
						</div>
					<% end_loop %>
				</div>

				<% if JuryProjectInfo %>
					<hr />
					<div class="projectJuryDocuments">
						<% loop JuryProjectInfo %>
							<div class="documentBlock">
								<div >
									$Text
								</div>
							</div>
						<% end_loop %>
					</div>
				<% end_if %>
			</div>
			<div class="clear"></div>
			<div class="text-center">
				<a href="jury/documentLinkUpload/$ID" class="btn btn-primary hideJuryLink">Info hinzuf&uuml;gen</a>
			</div>
		</div>
	<% end_loop %>
</aside>