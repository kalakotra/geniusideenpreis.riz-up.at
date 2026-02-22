<div class="container">
	<div class="row">
		<div class="col-12 col-md-7 col-lg-8">
			<div class="content"><h3>Zu bewertende Projekte</h3></div>
			<div class="content"><h4>Sie haben bereits $getCurrentUser.myProjectPercent % Ihrer Projekte bewertet.</h4></div>
			
			<table id="projectListTable" class="display" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		                <th>Proj. nr.</th>
		                <th>Projekttitel</th>
		                <th>Projektbeschreibung</th>
		                <th>Name</th>
		                <th>Firma</th>
		                <th>Status</th>
		                <th>Punkte*</th>
		            </tr>
		        </thead>
		        <tbody>
				<% loop getJuryProjects %>
					<tr class="$getJuryStatusForFrontend">
						<td valign="top">$ProjectNumber</td>
						<td valign="top"><a href="{$Top.Link}/projectDetailsJury/$ID">$Title</a></td>
						<td valign="top">$KurzBeschreibung.limitWordCount(30)</td>
						<td valign="top">$Vorname $Nachname</td>
						<td valign="top">$Firma</td>
						<td valign="top">$getJuryStatusForFrontend</td>
						<td valign="top">$getJuryPointsForFrontend</td>
					</tr>
				<% end_loop %>
				</tbody>
			</table>
			<p style="font-size: 10px; display: none;">
				* <br />
				IP - Innovations Punkte<br />
				MP - Markt Punkte<br />
				UP - Umsetzungsrelevanz Punkte<br />
				WP - Wirtschafts- oder gesellschaftspolit. Relevanz<br />
				QP - Qualitat Punkte
			</p>
		</div>
		<div class="col-12 cl-md-5 col-lg-4">
			<% if AnsprechPartner %>
				<% include SideBar %>
			<% end_if %>
		</div>
	</div>
</div>