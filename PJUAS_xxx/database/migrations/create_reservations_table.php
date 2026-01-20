Schema::create('reservations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained();
    $table->foreignId('hotel_id')->constrained();
    $table->date('check_in');
    $table->date('check_out');
    $table->decimal('total_price', 10, 2);
    $table->enum('status', ['pending', 'confirmed', 'cancelled']);
    $table->timestamps();
});
