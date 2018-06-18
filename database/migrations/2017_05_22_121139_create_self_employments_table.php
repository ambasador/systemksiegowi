<?php
/**
 * Migration genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Dwij\Laraadmin\Models\Module;

class CreateSelfEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Module::generate("Self_employments", 'self_employments', 'name_username', 'fa-user-md', [
            ["name_username", "Imię Nazwisko", "TextField", false, "", 0, 256, true],
            ["trade_name", "Nazwa handlowa", "TextField", false, "", 0, 256, true],
            ["we_support", "Obsługujemy", "Dropdown", false, "tak", 0, 0, true, ["tak","nie"]],
            ["registration_date", "Data rejestracji", "Date", false, "", 0, 0, true],
            ["phone_number", "Numer telefonu", "TextField", false, "", 0, 256, true],
            ["email_address", "Adres e-mail", "Email", false, "", 0, 256, true],
            ["annotations", "Dodatkowe uwagi", "Textarea", false, "", 0, 0, false],
            ["tax_return", "Tax Return", "TextField", false, "", 0, 256, true],
            ["payroll", "Payroll", "Dropdown", false, "tak", 0, 0, true, ["tak","nie"]],
            ["vat", "VAT", "Dropdown", false, "tak", 0, 0, true, ["tak","nie"]],
            ["vat_number", "numer VAT", "TextField", false, "", 0, 256, false],
            ["end_date_1", "Data okresu 1", "TextField", false, "", 0, 256, true],
            ["end_date_2", "Data okresu 2", "TextField", false, "", 0, 256, true],
            ["end_date_3", "Data okresu 3", "TextField", false, "", 0, 256, true],
            ["end_date_4", "Data okresu 4", "TextField", false, "", 0, 256, true],
        ]);
		
		/*
		Row Format:
		["field_name_db", "Label", "UI Type", "Unique", "Default_Value", "min_length", "max_length", "Required", "Pop_values"]
        Module::generate("Module_Name", "Table_Name", "view_column_name" "Fields_Array");
        
		Module::generate("Books", 'books', 'name', [
            ["address",     "Address",      "Address",  false, "",          0,  1000,   true],
            ["restricted",  "Restricted",   "Checkbox", false, false,       0,  0,      false],
            ["price",       "Price",        "Currency", false, 0.0,         0,  0,      true],
            ["date_release", "Date of Release", "Date", false, "date('Y-m-d')", 0, 0,   false],
            ["time_started", "Start Time",  "Datetime", false, "date('Y-m-d H:i:s')", 0, 0, false],
            ["weight",      "Weight",       "Decimal",  false, 0.0,         0,  20,     true],
            ["publisher",   "Publisher",    "Dropdown", false, "Marvel",    0,  0,      false, ["Bloomsbury","Marvel","Universal"]],
            ["publisher",   "Publisher",    "Dropdown", false, 3,           0,  0,      false, "@publishers"],
            ["email",       "Email",        "Email",    false, "",          0,  0,      false],
            ["file",        "File",         "File",     false, "",          0,  1,      false],
            ["files",       "Files",        "Files",    false, "",          0,  10,     false],
            ["weight",      "Weight",       "Float",    false, 0.0,         0,  20.00,  true],
            ["biography",   "Biography",    "HTML",     false, "<p>This is description</p>", 0, 0, true],
            ["profile_image", "Profile Image", "Image", false, "img_path.jpg", 0, 250,  false],
            ["pages",       "Pages",        "Integer",  false, 0,           0,  5000,   false],
            ["mobile",      "Mobile",       "Mobile",   false, "+91  8888888888", 0, 20,false],
            ["media_type",  "Media Type",   "Multiselect", false, ["Audiobook"], 0, 0,  false, ["Print","Audiobook","E-book"]],
            ["media_type",  "Media Type",   "Multiselect", false, [2,3],    0,  0,      false, "@media_types"],
            ["name",        "Name",         "Name",     false, "John Doe",  5,  250,    true],
            ["password",    "Password",     "Password", false, "",          6,  250,    true],
            ["status",      "Status",       "Radio",    false, "Published", 0,  0,      false, ["Draft","Published","Unpublished"]],
            ["author",      "Author",       "String",   false, "JRR Tolkien", 0, 250,   true],
            ["genre",       "Genre",        "Taginput", false, ["Fantacy","Adventure"], 0, 0, false],
            ["description", "Description",  "Textarea", false, "",          0,  1000,   false],
            ["short_intro", "Introduction", "TextField",false, "",          5,  250,    true],
            ["website",     "Website",      "URL",      false, "http://dwij.in", 0, 0,  false],
        ]);
		*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('self_employments')) {
            Schema::drop('self_employments');
        }
    }
}
