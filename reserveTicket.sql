DROP PROCEDURE IF EXISTS reserveTicket;
DELIMITER //

CREATE PROCEDURE reserveTicket
(
	userEmail VARCHAR(55), 
	name VARCHAR(55), 
	numSeats INT, 
	sid INT
)


BEGIN
-- define vars
	DECLARE userExists INT;
	DECLARE totalReservations INT;
	DECLARE tixNum VARCHAR(11);


-- check if user exists
	SELECT UserID INTO userExists
	FROM Users
	WHERE Email = userEmail;
	
-- if not create user
	IF userExists is NULL THEN
		INSERT INTO Users 
		VALUES (Default, name, userEmail);
	
		SELECT UserID INTO userExists
		FROM Users
		WHERE Email = userEmail;
	
	END IF;
	
	SELECT count(*) INTO totalReservations
	FROM Tickets
	WHERE UserID = userExists;

	SELECT concat(lpad(ShowingID,3, "0"), lpad(ShowID, 2, "0"), lpad(userExists, 4, "0"), lpad(totalReservations, 2, "0")) INTO tixNum
	FROM Showings
	WHERE ShowingID = sid;

	UPDATE Showings
	SET SeatsAvalible = (SeatsAvalible - numSeats)
	WHERE ShowingID = sid;
	
	INSERT INTO Tickets (ShowingID, UserID, TicketNum, NumSeats)
	VALUES (sid, userExists, tixNum, numSeats);

	
END //

DELIMITER ;
