<?php 
    use Carbon\Carbon; 
?>
<table class="table reviews-table">
    <tbody>
        @foreach ($reviews as $review)
        <?php
            $createdAt = Carbon::parse($review->created_at)->format('m-d H:i');
        ?>
        <tr>
            <td>
            	<div class="title-wrapper">
                    <span>{{ $review->name }}</span>
                    <div class="rating-wrapper">
                        @if($review->stars && $settings->rating == 1)                
                            <div data-stars="{{ $review->stars }}" class="user-stars"></div>              
                        @endif
                        <span class="review-date">{{ $createdAt }}</span>
                    </div>
                </div>
            	@php echo nl2br($review->description) @endphp
                @if($review->comment)
                <div class="review-comment">
                    {{ $review->comment }}
                <div>
                @endif
                @if(count($review->photos) > 0)
                    <div style="margin-top: 10px" data-id="{{ $review->id }}" class="{{ 'review-gallery review-gallery-' . $review->id }}">
                        @foreach($review->photos as $photo)
                            <a href="{{ asset('storage/reviews/original/' . $photo->photo) }}" data-caption="Image caption">
                                <img src="{{ asset('storage/reviews/thumbs/' . $photo->photo) }}">
                            </a>
                        @endforeach
                        
                    </div>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $reviews->render("pagination::bootstrap-4") !!}

<style type="text/css">
    .title-wrapper {
        font-weight: bold; 
        padding: 9px 0px 4px 0px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .rating-wrapper {
        display: inline;
        align-self: flex-end;
    }

    .review-comment {
        margin-left: 60px;
        margin-top: 10px;
        margin-bottom: 20px;
        font-size: 16px;
    }

    .review-date {
        margin-left: 10px;
        font-size: 14px;
        color: #E0E0E0;
    }

    table.reviews-table a {
        border-bottom: 0px solid !important;
    }

    .review-gallery a {
        margin-right: 10px;
    } 

    .review-gallery a img {
        max-height: 110px;
    }
</style>