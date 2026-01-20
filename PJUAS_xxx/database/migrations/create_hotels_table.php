Schema::create('hotels', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description');
    $table->string('address');
    $table->decimal('rating', 3, 2);
    $table->timestamps();
});
