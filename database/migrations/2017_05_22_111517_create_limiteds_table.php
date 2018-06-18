<?php
/**
 * Migration genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Dwij\Laraadmin\Models\Module;

class CreateLimitedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Module::generate("Limiteds", 'limiteds', 'company_name', 'fa-bank', [
            ["company_name", "Nazwa firmy", "TextField", false, "Firma w Anglii", 2, 350, true],
            ["we_share", "Obsługujemy", "Dropdown", false, "tak", 0, 0, true, ["tak","nie"]],
            ["share_address", "Udostępnienie adresu", "Dropdown", false, "tak", 0, 0, true, ["tak","nie"]],
            ["registration_date", "Data rejestracji", "Date", false, "", 0, 0, true],
            ["company_number", "Numer spółki", "TextField", false, "", 0, 256, true],
            ["contact_person", "Osoba kontaktowa", "TextField", false, "", 0, 256, true],
            ["phone_number", "Numer telefonu", "TextField", false, "", 0, 256, false],
            ["address_email", "Adres e-mail", "Email", false, "", 0, 256, true],
            ["contact_person_2", "Osoba kontaktowa 2", "TextField", false, "", 0, 256, false],
            ["phone_number_2", "Numer telefonu 2", "TextField", false, "", 0, 256, false],
            ["email_address_2", "Adres e-mail 2", "Email", false, "", 0, 256, false],
            ["first_set_period", "Początek I okresu", "Date", false, "", 0, 0, true],
            ["Eof_first_settlement", "Termin I rozliczenia", "Date", false, "", 0, 0, true],
            ["b_c_billing_periods", "Początek okresów", "TextField", false, "", 0, 256, true],
            ["end_of_set_period", "Koniec okresów", "TextField", false, "", 0, 256, true],
            ["end_of_periods", "Termin rozliczeń", "TextField", false, "", 0, 256, true],
            ["payroll", "Payroll", "Dropdown", false, "tak", 0, 0, true, ["tak","nie"]],
            ["vat", "VAT", "Dropdown", false, "tak", 0, 0, true, ["tak","nie"]],
            ["vat_numer", "Numer VAT", "TextField", false, "", 0, 256, false],
            ["date_periods_1", "Daty okresów 1", "TextField", false, "", 0, 256, true],
            ["date_periods_2", "Daty okresów 2", "TextField", false, "", 0, 256, true],
            ["date_periods_3", "Daty okresów 3", "TextField", false, "", 0, 256, true],
            ["date_periods_4", "Daty okresów 4", "TextField", false, "", 0, 256, true],
            ["additional_remarks", "Dodatkowe uwagi", "HTML", false, "test", 0, 0, true],
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
        if (Schema::hasTable('limiteds')) {
            Schema::drop('limiteds');
        }
    }
}
