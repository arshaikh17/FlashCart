<div class="policy_area">
		
	@forelse($policies as $policy)
	<div class="policy"> 
		<h3>{{ $policy->policy_title }}</h3>

		Description:
		<p>{{ $policy->policy_content }}</p>
	</div>
	@empty
	No policies by store.
	@endforelse

	{{ $policies->links() }}
</div>

<style>
.policy
{
	padding-top: 4px;
	padding-bottom: 10px;
	padding-left: 10px;
	padding-right: 10px;
	border-bottom: 2px solid lightgrey;
	border-left: 2px solid lightgrey;
	margin-bottom: 8px;
	width: 100% !important;
	transition: all .2s ease-in;
}
.policy_area
{
	margin-left: -10px;
}
.policy:hover
{
	box-shadow: 0px 0px 5px 2px lightgrey;
}
</style>