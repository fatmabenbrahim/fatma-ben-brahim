<?php

	function FindExit($MazeRunnerServer, $MyMaze)
	
	{	
		
		$MazeArray = array();
		// initialize curl
        $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        // The next line returns the response as the return value of the curl_exec command.
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
		$header_size = curl_getinfo($curl_handle, CURLINFO_HEADER_SIZE);
		
		
		// get starting position of MyMaze
		curl_setopt($curl_handle,CURLOPT_URL,$MazeRunnerServer."/mazes/".$MyMaze->code."/position/start");
        $response = curl_exec($curl_handle); // Make the request
		$header = substr($response, 0, $header_size);
		$body = json_decode(substr($response, $header_size));
		
		if ($header == "404 Not found")
		{
			echo "Either this maze does not exists or there are no starting points of it .. !";
			return;
		}
		else if ( $header == "200 OK") // start looking after the exit of the maze
		{
			$StartOfMyMaze = $body->position;
			$CurrentPosition = $StartOfMyMaze;
			$MazeArray[$StartOfMyMaze->x][$StartOfMyMaze->y] = "@";
			do
			{
				////////////////////////////// NORTH
				$RequestBody = BuildRequestBody($CurrentPosition, "NORTH"); 
				curl_setopt($curl_handle,CURLOPT_URL,$MazeRunnerServer."/mazes/".$MyMaze->code."/position");
			
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
													'Content-Type: application/json',
													'Content-Length: ' . strlen($data))
				);
				$Response = curl_exec($curl_handle); // Make the request
				$header = substr($Response, 0, $header_size);
				$body = json_decode(substr($response, $header_size));
				if ( $header == "200 OK" ) // position is a field
				{
					if (json_decode($body->position) == ".")
						$CurrentPosition = json_decode($body->position);
					$MazeArray[$body->position->x][$body->position->y] = $body->field;
				}
				else if ( $header == "418 I'm a teapot") // position is a wall
				{
					echo "Invalid move, please try again";
				}
				else if ( $header == "404 Not found") // maze not found
				{
					echo "maze not found";
					return;
				}
				
				////////////////////////////// WEST
				$RequestBody = BuildRequestBody($CurrentPosition, "WEST"); 
				curl_setopt($curl_handle,CURLOPT_URL,$MazeRunnerServer."/mazes/".$MyMaze->code."/position");
			
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
													'Content-Type: application/json',
													'Content-Length: ' . strlen($data))
				);
				$response = curl_exec($curl_handle); // Make the request
				$header = substr($response, 0, $header_size);
				$body = json_decode(substr($response, $header_size));
				if ( $header == "200 OK" ) // position is a field
				{
					if (json_decode($body->position) == ".")
						$CurrentPosition = json_decode($body->position);
					$MazeArray[$body->position->x][$body->position->y] = $body->field;
				}
				else if ( $header == "418 I'm a teapot") // position is a wall
				{
					echo "Invalid move, please try again";
				}
				else if ( $header == "404 Not found") // maze not found
				{
					echo "maze not found";
					return;
				}
				
				////////////////////////////// SOUTH
				$RequestBody = BuildRequestBody($CurrentPosition, "SOUTH"); /
				curl_setopt($curl_handle,CURLOPT_URL,$MazeRunnerServer."/mazes/".$MyMaze->code."/position");
			
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
													'Content-Type: application/json',
													'Content-Length: ' . strlen($data))
				);
				$response = curl_exec($curl_handle); // Make the request
				$header = substr($response, 0, $header_size);
				$body = json_decode(substr($response, $header_size));
				if ( $header == "200 OK" ) // position is a field
				{
					if (json_decode($body->position) == ".")
						$CurrentPosition = json_decode($body->position);
					$MazeArray[$body->position->x][$body->position->y] = $body->field;
				}
				else if ( $header == "418 I'm a teapot") // position is a wall
				{
					echo "Invalid move, please try again";
				}
				else if ( $header == "404 Not found") // maze not found
				{
					echo "maze not found";
					return;
				}
				
				////////////////////////////// EAST
				$RequestBody = BuildRequestBody($CurrentPosition, "EAST"); 
				curl_setopt($curl_handle,CURLOPT_URL,$MazeRunnerServer."/mazes/".$MyMaze->code."/position");
			
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
													'Content-Type: application/json',
													'Content-Length: ' . strlen($data))
				);
				$response = curl_exec($curl_handle); // Make the request
				$header = substr($response, 0, $header_size);
				$body = json_decode(substr($response, $header_size));
				if ( $header == "200 OK" ) // position is a field
				{
					if (json_decode($body->position) == ".")
						$CurrentPosition = json_decode($body->position);
					$MazeArray[$body->position->x][$body->position->y] = $body->field;
				}
				else if ( $header == "418 I'm a teapot") // position is a wall
				{
					echo "Invalid move, please try again";
				}
				else if ( $header == "404 Not found") // maze not found
				{
					echo "maze not found";
					return;
				}
					
			}while ($body->field) != "x")
			
			// Display the maze and the path to the exit
			$out  = "";
			$out .= "<table>";
			foreach($MazeArray as $key => $element){
				$out .= "<tr>";
				foreach($element as $subkey => $subelement){
					$out .= "<td>$subelement</td>";
				}
				$out .= "</tr>";
			}
			$out .= "</table>";

			echo $out;
		}
	}  
		
	function BuildRequestBody($PositionInMaze, $Direction)
	{
		$PosX = $PositionInMaze->x;
		$PosY = $PositionInMaze->y;
		$RequestBody = "{
							'from': {
							   'x': $PosX,
							   'y': $PosY
							},
							'direction': '$Direction'
						}";
		return $RequestBody;
	}
	
	function UnitTest()
	{
		$MazeRunnerServer = "http://localhost:8080/swagger-ui";
		// initialize curl
        $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        // The next line returns the response as the return value of the curl_exec command.
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
		$header_size = curl_getinfo($curl_handle, CURLINFO_HEADER_SIZE);
		
		// get list of mazes codes.
        curl_setopt($curl_handle,CURLOPT_URL,$MazeRunnerServer."mazes");
        $ListOfMazes = curl_exec($curl_handle); // Make the request
		
		$MyMaze = json_decode($ListOfMazes[0]); // pick the first one in the list of mazes
		
		FindExit($MazeRunnerServer, $MyMaze)
	}
		