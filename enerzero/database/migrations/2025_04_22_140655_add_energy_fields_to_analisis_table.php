public function up()
{
    Schema::table('analisis', function (Blueprint $table) {
        $table->float('total_daya')->default(0)->after('user_id');
        $table->string('unit_pengukuran', 10)->default('kWh')->after('total_daya');
        $table->enum('periode', ['harian', 'bulanan', 'tahunan'])->default('bulanan')->after('unit_pengukuran');
    });
}

public function down()
{
    Schema::table('analisis', function (Blueprint $table) {
        $table->dropColumn(['total_daya', 'unit_pengukuran', 'periode']);
    });
}
