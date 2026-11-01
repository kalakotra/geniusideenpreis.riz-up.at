<aside>
	<% if AnsprechPartner %>
		<% with AnsprechPartner %>
			<div class="contactPersonWidget">
				<h3 class="headline rizblue">Ansprechperson</h3>
				$Picture.Fill(250, 350)
				<div class="widgetTexts">
					$Name
					<br />
					T $Telephone <br />
					$SubPosition <br />
					
					<a href="mailto:$Email"><%t ContactPersonWidget.WRITEEMAIL "E-Mail" %></a>
				</div>
				<div class="clearfix"></div>
			</div>
		<% end_with %>
	<% end_if %>
	<% if WeitereInfo %>
		<div class="moreInfoWidget">
			<h3 class="headline rizblue">Weitere Informationen</h3>
			<a href="$WeitereInfo.URL" target='_blank'>$WeitereInfo.Title</a>
		</div>
	<% end_if %>
</aside>
