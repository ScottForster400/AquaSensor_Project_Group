<?php
    namespace App\View\Components;

    use Illuminate\View\Component;
    
    class SearchBarGps extends Component
    {
        public $Sensors;
    
        public function __construct($Sensors)
        {
            dd($Sensors);
            $this->Sensors = $Sensors; 
        }
    
        public function render()
        {
            return view('components.search-bar-gps');
        }
    }
    
?>