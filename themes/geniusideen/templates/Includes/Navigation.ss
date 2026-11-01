<div class="competitionMenu">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav class="primary">
					<% if getCurrentUser %>
						<% loop getAllCompetitions.filter("HideFromMenu", "0").sort("ID DESC") %>
							<a href="$Top.Link/changeCompetition/$ID" class="animated <% if menuActiveCompetition %>active<% end_if %>">$Title</a>
						<% end_loop %>
					<% end_if %>
					&nbsp;
				</nav>
			</div>
		</div>
	</div>
</div>