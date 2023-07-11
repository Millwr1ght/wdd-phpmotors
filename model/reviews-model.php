<?php 
    //reviews model

    function insertReview($clientId, $invId, $reviewText) {
        # add review to the database
        $db = phpmotorsConnect();
        $sql = 'INSERT INTO reviews (clientId, invId, reviewText) VALUES (:clientId, :invId, :reviewText);';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
        $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
        $stmt->execute();
        $rowsChanged = $stmt->rowCount();
        $stmt->closeCursor();
        return $rowsChanged;
    }

    function getProductReviews($invId) {
        # get all reviews for given inventory id
        $db = phpmotorsConnect();
        $sql = 'SELECT r.reviewId, r.reviewText, r.reviewDate, r.clientId, c.clientFirstname, c.clientLastname FROM reviews r JOIN clients c ON r.clientId = c.clientId WHERE invId = :invId;';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
        $stmt->execute();
        $productReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $productReviews;
    }

    function getClientReviews($clientId) {
        # get all reviews associated with given client id
        $db = phpmotorsConnect();
        $sql = 'SELECT r.reviewId, r.reviewText, r.reviewDate, r.clientId, c.clientFirstname, c.clientLastname, r.invId, i.invMake, i.invModel FROM reviews r JOIN clients c ON r.clientId = c.clientId JOIN inventory i ON r.invId = i.invId WHERE clientId = :clientId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        $stmt->execute();
        $productReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $productReviews;
    }

    function getReview($reviewId) {
        # get reviews by review id
        $db = phpmotorsConnect();
        $sql = 'SELECT r.reviewId, r.reviewText, r.reviewDate, r.clientId, c.clientFirstname, c.clientLastname, r.invId, i.invMake, i.invModel FROM reviews r JOIN clients c ON r.clientId = c.clientId JOIN inventory i ON r.invId = i.invId WHERE reviewId = :reviewId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        //there should only be one, given that there should be one id per review
        $productReview = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $productReview;
    }

    function updateReview($reviewId, $reviewText) {
        # update review text by review id
        $db = phpmotorsConnect();
        $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId;';
        $stmt = $db->prepare($sql);
        # replace placeholders
        $stmt->bindValue(':reviewText', $reviewText,PDO::PARAM_STR);
        $stmt->bindValue(':reviewId', $reviewId,PDO::PARAM_INT);
        $stmt->execute();
        $rowsChanged = $stmt->rowCount();
        $stmt->closeCursor();
        return $rowsChanged;
    }

    function deleteReview($reviewId) {
        # delete review by review id
        $db = phpmotorsConnect();
        $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        $rowsChanged = $stmt->rowCount();
        $stmt->closeCursor();
        return $rowsChanged;
    }

?>