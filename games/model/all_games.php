<?php
	class GuessGame {
		public $secretNumber = 5;
		public $numGuesses = 0;
		public $history = array();
		public $state = "";

		public function __construct() {
			$this->secretNumber = rand(1,10);
		}
		
		public function makeGuess($guess){
			$this->numGuesses++;
			if($guess>$this->secretNumber){
				$this->state="too high";
			} else if($guess<$this->secretNumber){
				$this->state="too low";
			} else {
				$this->state="correct";
			}
			$this->history[] = "Guess #$this->numGuesses was $guess and was $this->state.";
		}

		public function getState(){
			return $this->state;
		}
	}

	class RockPaperScissors {
		public $secretNumber = 1;
		public $numGuesses = 0;
		public $history = array();
		public $state = "";
	
		public function __construct() {
			$this->secretNumber = rand(1,3);
		}
		
		public function makeGuess($guess){
			$this->numGuesses++;
			if($guess==1 && $this->secretNumber==2){
				$this->state="You lose";
				$this->history[] = "Game #$this->numGuesses. You picked Rock and computer picked Paper. $this->state.";
			} else if($guess==2 && $this->secretNumber==3){
				$this->state="You lose";
				$this->history[] = "Game #$this->numGuesses. You picked Paper and computer picked Scissors. $this->state.";
			} else if($guess==3 && $this->secretNumber==1){
				$this->state="You lose";
				$this->history[] = "Game #$this->numGuesses. You picked Scissors and computer picked Rock. $this->state.";
			} else if($guess==1 && $this->secretNumber==3){
				$this->state="You win";
				$this->history[] = "Game #$this->numGuesses. You picked Rock and computer picked Scissors. $this->state.";
			} else if($guess==2 && $this->secretNumber==1){
				$this->state="You win";
				$this->history[] = "Game #$this->numGuesses. You picked Paper and computer picked Rock. $this->state.";
			} else if($guess==3 && $this->secretNumber==2){
				$this->state="You win";
				$this->history[] = "Game #$this->numGuesses. You picked Scissors and computer picked Paper. $this->state.";
			} else if($guess==1 && $this->secretNumber==1){
				$this->state="It was a draw";
				$this->history[] = "Game #$this->numGuesses. You picked Rock and computer picked Rock. $this->state.";
			} else if($guess==2 && $this->secretNumber==2){
				$this->state="It was a draw";
				$this->history[] = "Game #$this->numGuesses. You picked Paper and computer picked Paper. $this->state.";
			}  else if($guess==3 && $this->secretNumber==3){
				$this->state="It was a draw";
				$this->history[] = "Game #$this->numGuesses. You picked Scissors and computer picked Scissors. $this->state.";
			}
			$this->secretNumber = rand(1,3);
		}
	
		public function getState(){
			return $this->state;
		}
	}

	class Frogs {
		public $positions = array();
		public $numSolved = 0;
		public $history = array();
		public $state = "incorrect";

		public function __construct() {
			$this->positions = array("L","L","L","E","R","R","R");
		}
		
		public function clickOnFrog($index){
			if($this->positions[(int)$index] == "L"){
				if((int)$index+1<=6 && $this->positions[(int)$index] != $this->positions[(int)$index+1]){
					if((int)$index+2<=6 && $this->positions[(int)$index+1] == "R" && $this->positions[(int)$index+2] == "E"){
						$this->positions[(int)$index] = "E";
						$this->positions[(int)$index+2] = "L";
					} else if ((int)$index+1<=6 && $this->positions[(int)$index+1] == "E"){
						$this->positions[(int)$index] = "E";
						$this->positions[(int)$index+1] = "L";
					}
				} 
			} else if($this->positions[(int)$index] == "R"){
				if((int)$index-1>=0 && $this->positions[(int)$index] != $this->positions[(int)$index-1]){
					if($index-2>=0 && $this->positions[(int)$index-1] == "L" && $this->positions[(int)$index-2] == "E"){
						$this->positions[(int)$index] = "E";
						$this->positions[(int)$index-2] = "R";
					} else if ((int)$index-1>=0 && $this->positions[(int)$index-1] == "E"){
						$this->positions[(int)$index] = "E";
						$this->positions[(int)$index-1] = "R";
					}
				}
			}
			if($this->positions == array("R","R","R","E","L","L","L")){
				$this->numSolved++;
				$this->state = "correct";
				$this->history[] = "Congratulations! You have solved the puzzle";
			}
		}

		public function getState(){
			return $this->state;
		}

		public function getPosition(){
			return $this->positions;
		}
	}
?>

