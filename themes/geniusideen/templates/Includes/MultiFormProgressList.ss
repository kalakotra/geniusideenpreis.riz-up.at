<% loop $AllStepsLinear %>
    <% if $LinkingMode = current %>
        $Content
    <% end_if %>
<% end_loop %>
<div class="bg-light mb-3 rounded-lg overflow-hidden">
    <div class="row m-0">
        <% loop $AllStepsLinear %>
            <div class="col-3 px-0 py-2 text-center <% if $LinkingMode = current %> bg-primary text-white <% end_if %>">
                $Title
            </div>
        <% end_loop %>
    </div>
</div>