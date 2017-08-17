<div class="view-content">
    {if $periods}
        <div id="memberships">
            <div class="form-item">
                {strip}
                    <table>
                        <tr class="columnheader">
                            <th></th>
                            <th>{ts}Membership ID{/ts}</th>
                            <th>{ts}Start Date{/ts}</th>
                            <th>{ts}End Date{/ts}</th>
                            <th>{ts}Renewal Date{/ts}</th>
                        </tr>
                        {foreach from=$periods item=period name=periods}
                            <tr class="{cycle values="odd-row,even-row"}">
                                <td>{$smarty.foreach.periods.index+1}</td>
                                <td>{$period.membership_id}</td>
                                <td>{$period.start_date|crmDate}</td>
                                <td>{$period.end_date|crmDate}</td>
                                <td>{$period.modified_date|crmDate}</td>
                            </tr>
                        {/foreach}
                    </table>
                {/strip}

            </div>
        </div>
    {else}
        <div id="memberships">No Membership period found!</div>
    {/if}
</div>
