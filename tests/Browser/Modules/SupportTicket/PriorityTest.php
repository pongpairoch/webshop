<?php

namespace Tests\Browser\Modules\SupportTicket;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Modules\SupportTicket\Entities\TicketPriority;
use Tests\DuskTestCase;

class PriorityTest extends DuskTestCase
{

    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();


    }

    public function tearDown(): void
    {
        $priorities = TicketPriority::where('id', '>', 3)->pluck('id');
        TicketPriority::destroy($priorities);

        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_index_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/admin/ticket/priorities')
                    ->assertSee('Priority List');
        });
    }

    public function test_for_create_priority(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#name', 'test-priority')
                ->click('#add_form > div > div:nth-child(1) > div.col-xl-12 > div > ul > li:nth-child(2) > label > span')
                ->click('#submit_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Created successfully!');
        });
    }

    public function test_for_validate_create(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#name', '')
                ->click('#add_form > div > div:nth-child(1) > div.col-xl-12 > div > ul > li:nth-child(2) > label > span')
                ->click('#submit_btn')
                ->waitForText('The name field is required.', 25)
                ->type('#name', 'High')
                ->pause(1000)
                ->click('#submit_btn')
                ->waitForText('The name has already been taken.', 25);
        });
    }

    public function test_for_edit_priority(){
        $this->test_for_create_priority();
        $this->browse(function (Browser $browser) {
            $browser->type('#DataTables_Table_1_filter > label > input[type=search]', 'test-priority')
                ->pause(6000)
                ->click('#sku_tbody > tr:nth-child(1) > td:nth-child(4) > div > button')
                ->click('#sku_tbody > tr:nth-child(1) > td:nth-child(4) > div > div > a.dropdown-item.edit_priority')
                ->waitForText('Edit', 25)
                ->type('#name', 'test-priority-edit')
                ->click('#edit_form > div > div:nth-child(1) > div.col-xl-12 > div > ul > li:nth-child(1) > label > span')
                ->click('#submit_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_delete_priority(){
        $this->test_for_create_priority();
        $this->browse(function (Browser $browser) {
            $browser->type('#DataTables_Table_1_filter > label > input[type=search]', 'test-priority')
                ->pause(6000)
                ->click('#sku_tbody > tr:nth-child(1) > td:nth-child(4) > div > button')
                ->click('#sku_tbody > tr:nth-child(1) > td:nth-child(4) > div > div > a.dropdown-item.delete_priority')
                ->whenAvailable('#item_delete_form', function($modal){
                    $modal->click('#dataDeleteBtn');
                })
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');
        });        
    }

    public function test_for_update_status(){
        $this->test_for_create_priority();
        $this->browse(function (Browser $browser) {
            $browser->type('#DataTables_Table_1_filter > label > input[type=search]', 'test-priority')
                ->pause(6000)
                ->click('#sku_tbody > tr:nth-child(1) > td:nth-child(3) > label > div')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });        
    }
}
