<% include MultiFormProgressList %>

<div class="multiform-step">
    <% if $Message %>
    <p class="alert alert-{$MessageType}">$Message</p>
    <% end_if %>
    
    <% if $IncludeFormTag %>
    <form $AttributesHTML>
    <% end_if %>
        
        <fieldset>
            <div class="card mb-3">
                <% loop $Fields %>
                    <% if $name == "header" %>
                        <% if $isFirst %><% else %>
                        </div></div><div class="card mb-3">
                        <% end_if %>
                        <div class="card-header">
                            $Field
                        </div>
                        <div class="card-body bg-light">
                    <% else %>
                        $FieldHolder
                    <% end_if %>

                    <% if $isLast %>
                        </div>
                    <% end_if %>
                <% end_loop %>
            </div>
        </fieldset>
        
        <% if $Actions %>
        <div class="form-actions">
            <% loop $Actions %>
                $Field
            <% end_loop %>
            <a href="javascript:window.print();" class="btn btn-secondary mt-3 grid-2">Drucken</a>
        </div>
        <% end_if %>
        
    <% if $IncludeFormTag %>
    </form>
    <% end_if %>
</div>