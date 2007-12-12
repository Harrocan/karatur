{literal}
<style type="text/css">
	.rank-body {
	border: solid 3px #0c1115;
	margin: 5px;
	}
	.rank-title {
	background: #0c1115;
	padding-left:15px;
	}
	.rank-desc {
	padding:5px;
	}
	.rank-salary{
	font-style:italic;
	}
	.rank-users-total{
	position:relative;
	}
	.rank-users-more{
	position:absolute;
	right:0px;
	top:0px;
	cursor:pointer;
	}
	div.rank-users-more:hover{
	color:white;
	}
	.rank-users-list{
	margin-top:5px;
	margin-bottom:5px;
	display:none;
	}
</style>
<script type="text/javascript">
	function showUsers( rid ) {
		var el = document.getElementsByName( 'rank-list-' + rid )[0];
		//alert( el.innerHTML );
		if( el.style.display == 'none' ) {
			el.style.display = 'block';
		}
		else {
			el.style.display = 'none';
		}
	}
</script>
{/literal}
{section name=rv loop=$Ranks}
{assign value=$Ranks[rv] var='Rank'}
<div class="rank-body">
	<div class="rank-title"><img src="images/ranks/{$Rank.image}"/> {$Rank.name}</div>
	<div class="rank-desc">{if $Rank.desc}{$Rank.desc}{else}<i>brak opisu rangi</i>{/if}</div>
	{if $Rank.salary > 0 }<div class="rank-salary">Wynagrodzenie : {$Rank.salary} sztuk z³ota/tydzieñ</div>{/if}
	<div class="rank-users">
		<div class="rank-users-total">{if $Rank.amount>0}{$Rank.amount} gracz(y) posiada t± rangê<div onclick="showUsers({$Rank.id})" class="rank-users-more">rozwiñ/zwiñ</div>{else}W królestwie nie ma nikogo z tak± rang±{/if}</div>
		<ul class="rank-users-list" name="rank-list-{$Rank.id}" style="display:none">
			{section name=rl loop=$Rank.users}
			{assign value=$Rank.users[rl] var='User'}
			<li><a href="view.php?view={$User.id}">{$User.user}</a> (id {$User.id})</li>
			{/section}
		</ul>
	</div>
</div>
{/section}