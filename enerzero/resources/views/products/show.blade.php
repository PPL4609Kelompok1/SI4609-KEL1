<h3>Ulasan Produk</h3>
@foreach ($product->reviews as $review)
    <p><strong>{{ $review->user_name }}</strong>: {{ $review->content }}</p>
@endforeach

<form method="POST" action="{{ route('review.store', $product->id) }}">
    @csrf
    <input type="text" name="user_name" placeholder="Nama Anda">
    <textarea name="content" placeholder="Tulis ulasan..."></textarea>
    <button type="submit">Kirim Ulasan</button>
</form>
