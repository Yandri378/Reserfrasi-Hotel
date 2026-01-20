Schema::create('rooms', function (Blueprint $table) {
    $table->id();
    $table->foreignId('hotel_id')->constrained();
    $table->string('room_number');
    $table->string('type');
    $table->decimal('price_per_night', 10, 2);
    $table->integer('capacity');
    $table->enum('status', ['available', 'occupied', 'maintenance']);
    $table->timestamps();
});
