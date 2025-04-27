@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ isset($review) ? route('reviews.update', $review) : route('reviews.store') }}">
    @csrf
    @if(isset($review))
        @method('PUT')
    @endif

    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="form-group">
        <label for="rating">Rating</label>
        <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" required>
            <option value="">Select a rating</option>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ (isset($review) && $review->rating == $i) ? 'selected' : '' }}>
                    {{ $i }} {{ $i == 1 ? 'star' : 'stars' }}
                </option>
            @endfor
        </select>
        @error('rating')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="comment">Review Comment</label>
        <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" rows="4" required>{{ isset($review) ? $review->comment : old('comment') }}</textarea>
        @error('comment')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            {{ isset($review) ? 'Update Review' : 'Submit Review' }}
        </button>
        <a href="{{ route('products.show', $review->product_id ?? $product->id) }}" class="btn btn-secondary">Cancel</a>
    </div>
</form> 