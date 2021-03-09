<table class="table">
    <tbody>
        @foreach ($reviews as $review)
        <tr>
            <td>
            	<div style="font-weight: bold; padding: 8px 0px;">{{ $review->name }}</div>
            	@php echo nl2br($review->description) @endphp
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $reviews->render("pagination::bootstrap-4") !!}