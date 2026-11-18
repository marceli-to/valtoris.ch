<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Every message from the contact form, kept in case the email to valtoris goes astray. */
return new class extends Migration
{
	public function up(): void
	{
		Schema::create('contact_messages', function (Blueprint $table) {
			$table->id();
			$table->string('salutation')->nullable();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('phone')->nullable();
			$table->text('message')->nullable();
			$table->timestamp('mailed_at')->nullable();
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('contact_messages');
	}
};
