<?php
require_once INCLUDE_DBMANAGER;

//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.


class queryManager extends dbManager {
    
    //The actual function that every queryFunction uses,
    //this function calls for functions in the dbManager:
    function handleQuery($query) {
        $this->manager = new dbManager();
        $this->manager->openConnection();
        $this->manager->doQuery($query);
        $content = $this->manager->fetch();
        $this->manager->closeConnection(); 
        
        return $content;
    }
    
    //the actual function that every updateFunction uses,
    //this function calls for functions in the dbManager:    
    function writeQuery($query) {
        $this->manager = new dbManager();
        $this->manager->openConnection();
        $this->manager->executeQuery($query);
        $this->manager->closeConnection(); 
    }
    
    //Query function to retrieve the menu for both front end and back end.
    function getMenu() {
        $query = "SELECT menuCategoryID, menuTitle, menuLink FROM Core_Menu";
       
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function to retrieve the articles for the backend
    function getArticles() {
        $query = "SELECT Core_Article.categoryID, Core_Category.categoryName, Core_Article.pageID, Core_Page.pageName,
                  Core_Article.artID, Core_Article.title, Core_Article.creationDate, Core_Article.modifyDate, Core_Article.accessLevel
                  FROM Core_Article
                  INNER JOIN Core_Category ON Core_Category.categoryID = Core_Article.categoryID
                  INNER JOIN Core_Page ON Core_Page.pageID = Core_Article.pageID
                 ";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function to retrieve all users for the backend
    function getUsers() {
        $query = "SELECT Core_Users.userID, Core_Users.name, Core_Users.emailAddress, Core_Users.accessLevel
                 FROM Core_Users";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function to retrieve the criteria for the homepage
    function getCriteria() {
        $query = "SELECT Core_Criteria.criteriaType, Core_Criteria.criteriaName, Core_CriteriaValues.criteriaType, 
                    Core_CriteriaValues.criteriaValueID, Core_CriteriaValues.criteriaValueName, Core_CriteriaValues.criteriaValue
                  FROM Core_Criteria 
                  INNER JOIN Core_CriteriaValues ON Core_Criteria.criteriaType = Core_CriteriaValues.criteriaType";
        
        $content = $this->handleQuery($query);
        
        return $content;  
    }
    
    //Query function to retrieve the criteriatypes for the homepage
    function getCriteriaTypes() {
        $query = "SELECT Core_Criteria.criteriaType, Core_Criteria.criteriaName
                 FROM Core_Criteria";
     
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function to retrieve the various menu types for both the front- and backend
    function getMenuCategories() {
        $query = "SELECT Core_MenuCategory.menuCategoryID, Core_MenuCategory.categoryName, Core_MenuCategory.imageFolderPath
                 FROM Core_MenuCategory";
     
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function to retrieve all pages from the DB
    function getPages() {
        $query = "SELECT Core_Page.pageID, Core_Page.pageName
                 FROM Core_Page";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function to retrieve the details for an article
    function getArticleDetails($id){
        $query = "SELECT Core_Article.categoryID, Core_Category.categoryName, Core_Article.pageID, Core_Page.pageName,
                  Core_Article.artID, Core_Article.title, Core_Article.creationDate, Core_Article.modifyDate, Core_Article.accessLevel, 
                  Core_Article.author, Core_Article.body, Core_Article.modifiedBy
                  FROM Core_Article
                  INNER JOIN Core_Category ON Core_Category.categoryID = Core_Article.categoryID
                  INNER JOIN Core_Page ON Core_Page.pageID = Core_Article.pageID
                  WHERE Core_Article.artID = '$id'";
        
        $content = $this->handleQuery($query); 
        
        return $content;
    }
    
    //Query function to retrieve all schools from the database
    function getSchools(){
       $query = "SELECT Profile_School.BRIN, Profile_School.schoolName, Profile_School.educationTypeID, Profile_School.schoolType, Profile_School.website, 
                        Profile_School.address, Profile_School.postalCode, Profile_School.logoPath, Profile_School.childCare, Profile_School.boardID, Profile_School.emailAddress, Profile_School.schoolLat, Profile_School.schoolLong,  Profile_School.mission, Profile_School.vision,
                        Profile_Board.boardID, Profile_Board.boardName, Profile_EducationType.educationTypeID, Profile_EducationType.educationType
                        

                        FROM Profile_School
                        INNER JOIN Profile_Board ON Profile_School.boardID = Profile_Board.boardID 
                        INNER JOIN Profile_EducationType ON Profile_School.educationTypeID = Profile_EducationType.educationTypeID";
                 
                     
       
       
       $content = $this->handleQuery($query);
       
       return $content;
   }
   
   //Query function to retrieve one particular school from the database
   function getSchool($BRIN){
       $query = "SELECT Profile_School.BRIN, Profile_School.schoolName, Profile_School.educationTypeID, Profile_School.schoolType, Profile_School.website, 
                        Profile_School.address, Profile_School.postalCode, Profile_School.logoPath, Profile_School.childCare, Profile_School.boardID, Profile_School.emailAddress, Profile_School.schoolLat, Profile_School.schoolLong, Profile_School.mission, Profile_School.vision,
                        Profile_Board.boardID, Profile_Board.boardName, Profile_EducationType.educationTypeID, Profile_EducationType.educationType


                        FROM Profile_School
                        INNER JOIN Profile_Board ON Profile_School.boardID = Profile_Board.boardID 
                        INNER JOIN Profile_EducationType ON Profile_School.educationTypeID = Profile_EducationType.educationTypeID
   
                        WHERE Profile_School.BRIN = '$BRIN'";
       
       
       $content = $this->handleQuery($query);
       
       return $content;
   }
   
   //Query function to retrieve schoolcontext for the tabs for that particular school
   function getContext($BRIN){
     $query = "SELECT * FROM Profile_SchoolContext WHERE Profile_SchoolContext.BRIN ='$BRIN'";
     $content = $this->handleQuery($query);
     
     return $content;
   }
   
   //Query function to retrieve all 'tabs' (for schoolprofile and schoolcomparison)
   function getTabs(){
       $query ="SELECT *
        FROM `Profile_Tab`
        ORDER BY `Profile_Tab`.`tabID` ASC";               
       $content = $this->handleQuery($query);
       
       return $content;
   }
   
   //Query function used to determine that the login is in fact the uesr:
   function validateUser($uname) {
       $query = "SELECT Core_Users.name, Core_Users.password 
                FROM Core_Users 
                WHERE Core_Users.name = '$uname'";
       
       $content = $this->handleQuery($query);
       
       return $content;
   }
   
   //Query function to upload the user's authenticationcode (after login):
   function updateAuthCode($authcode, $uname) {
       $query = "UPDATE Core_Users SET authcode = '$authcode' WHERE name = '$uname'";
       
       $content = $this->writeQuery($query);
       
       return $content;
   }
   
   //Query function to retrieve the authcode from the database
   function checkAuthCode($uname) {
       $query = "SELECT Core_Users.authcode
                FROM Core_Users
                WHERE Core_Users.name = '$uname'";
       $content = $this->handleQuery($query);
       
       return $content;
   }
   
   //Query function to remove the authcode from the database, used when a user logs out
   function destroyAuthCode($uname) {
       $query = "UPDATE Core_Users SET authcode = NULL WHERE name = '$uname'";
       
       $content = $this->writeQuery($query);
       
       return $content;
   }
  
   //Query function to retrieve the different categories there are for articles
   function getArticleCategories() { 
        $query = "SELECT Core_Category.categoryID, Core_Category.categoryName
                  FROM Core_Category";
        
        $content = $this->handleQuery($query); 
        
        return $content;
    }
    
    //Query function, used to determine on which page an article should be placed:
    function getArticlePages() {
        $query = "SELECT Core_Page.pageID, Core_Page.pageName
                  FROM Core_Page";
        
        $content = $this->handleQuery($query); 
        
        return $content;
    } 
    
    //Query function to upload edited information to the database
    function editArticle($formValues, $uname){ 
        $artID = $formValues[0]['artID'];
        $title = $formValues[0]['title'];
        $body = $formValues[0]['body'];
        $categoryID = $formValues[0]['categoryID'];
        $pageID = $formValues[0]['pageID'];
        
        $query = "UPDATE Core_Article
                 SET title = '$title', body = '$body', modifiedBy = '$uname', categoryID = '$categoryID', pageID = '$pageID'
                 WHERE Core_Article.artID = '$artID'";
        
        $content = $this->writeQuery($query); 
        
        return "updateSucc";
    }
    
    //Query function used to determine the user is valid, used for password reset
    function checkPassReset($uname, $email) {
        $query = "SELECT Core_Users.userID 
                 FROM Core_Users
                 WHERE Core_Users.name='$uname' AND Core_Users.emailAddress='$email'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function used to upload the new user password:
    function updatePassword($veriCode, $newPassword) {
        $query = "UPDATE Core_Users 
                 SET password = '$newPassword', verifyCode = NULL
                 WHERE verifyCode = '$veriCode'";
        
        $content = $this->writeQuery($query);
        
        return $newPassword;
    }
    
    //Query function to upload a verificationcode, after user has requested a password reset    
    function uploadVeriCode($uname, $email, $veriCode) {
        $query = "UPDATE Core_Users
                 SET verifyCode = '$veriCode'
                 WHERE name='$uname' AND emailAddress='$email'";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    
    //Query function to determine if the verificationcode a user has submitted is equal to the one in the database
    function checkVeriCode($veriCode) {
        $query = "SELECT Core_Users.name, Core_Users.emailAddress
                 FROM Core_Users
                 WHERE Core_Users.verifyCode = '$veriCode'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    
    function checkAllUsers() {      
        $query = "SELECT Core_Users.name, Core_Users.emailAddress, Core_Users.verifyCode
                 FROM Core_Users";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function to retrieve a particular category
    function getCategory($id) {
        $query = "SELECT Core_Category.categoryID, Core_Category.categoryName
                 FROM Core_Category
                 WHERE Core_Category.categoryID = '$id'";
        
        $content = $this->handleQuery($query);;
        
        return $content;
    }
    
    //Query function to retrieve a particular menu category
    function getMenuCategory($id) {
        $query = "SELECT Core_MenuCategory.menuCategoryID, Core_MenuCategory.categoryName, Core_MenuCategory.imageFolderPath
                 FROM Core_MenuCategory
                 WHERE Core_MenuCategory.menuCategoryID = '$id'";
        
        $content = $this->handleQuery($query);;
        
        return $content;
    }
    
    //Query function to retrieve a particular page
    function getPage($id) {
        $query = "SELECT Core_Page.pageID, Core_Page.pageName
                 FROM Core_Page
                 WHERE pageID = '$id'";
        
        $content = $this->handleQuery($query);;
        
        return $content;
    }
    
    //Query function to retrieve a particular criterium
    function getCriterium($id) {
        $query = "SELECT Core_Criteria.criteriaType, Core_Criteria.criteriaName
                 FROM Core_Criteria
                 WHERE criteriaType = '$id'";
        $content = $this->handleQuery($query);
        return $content;
    }
    
    //Query function to retrieve static data of all students of a particular school
    function getStudentStaticData($BRIN){
        $query = "SELECT DISTINCT Profile_Student.studentID_BSN, Profile_Student.weightType, Profile_Student.postalCode
                  FROM Profile_Student
                  WHERE Profile_Student.BRIN = '$BRIN'   ";
               
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function to retrieve the number of students for a particular school
    function getStudentTotal($BRIN, $year){
        $query = "SELECT year, totalStudents FROM Profile_StudentWeightDET WHERE BRIN ='$BRIN' AND year ='$year'";
        $content = $this->handleQuery($query);
        
        return $content;  
    }
    
    //Query function to retrieve the number of students for a particular school
    function getStudentTotal2($BRIN, $YEAR){
        $query = "SELECT SUM( Profile_StudentAreaDET.total ) AS totalstudents
                    FROM Profile_StudentAreaDET
                    WHERE Profile_StudentAreaDET.BRIN = '$BRIN'
                    AND Profile_StudentAreaDET.year = '$YEAR'  ";
        
                
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function used to get X and Y coordinates of a postalCode
    function getPostalCodeInfo($gekozenPostcode){
        $query = "SELECT Profile_PostalCode.yCoordinate, Profile_PostalCode.xCoordinate
                 FROM Profile_PostalCode 
                 WHERE postalCode = '$gekozenPostcode'";
        
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function used to get all information of a school, including location coordinates
    function getSchoolPostalCode() {
        $query = "SELECT Profile_School.schoolName, Profile_School.address, Profile_School.educationTypeID,
                 Profile_EducationType.educationType, Profile_School.postalCode, Profile_School.xCoordinate, 
                 Profile_School.yCoordinate, Profile_School.schoolLat, Profile_School.schoolLong
                 FROM Profile_School
                 INNER JOIN Profile_EducationType ON Profile_School.educationTypeID = Profile_EducationType.educationTypeID";
                 
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function to get X and Y coordinates of a particular school
    function getSchoolPostalCodeXY($BRIN) {
        $query = "SELECT Profile_School.xCoordinate, Profile_School.yCoordinate
                 FROM Profile_School
                 WHERE BRIN='$BRIN'";
        $content = $this->handleQuery($query);
        
        return $content;
    }
    
    //Query function that is used to determine that the 'login' of a school is correct
    function schoolAuth($brin) {
        $query = "SELECT Profile_School.emailAddress
                FROM Profile_School
                WHERE BRIN='$brin'";

        $content = $this->handleQuery($query);

        return $content;
    }

    //get all school info for a particular school
    function getFrontendSchool($brin) {
        $query = "SELECT *
                FROM Profile_School
                INNER JOIN Profile_Board ON Profile_School.boardID = Profile_Board.boardID 
                INNER JOIN Profile_EducationType ON Profile_School.educationTypeID = Profile_EducationType.educationTypeID
                WHERE BRIN='$brin'";

        $content = $this->handleQuery($query);

        return $content;
    }
    
    //Query function used to check if a field has been edited
    function checkFields($fieldName, $fieldValue, $brin) {
        $query = "SELECT *
                  FROM Profile_School 
                  WHERE BRIN='$brin'";
        
        $content = $this->handleQuery($query);
        
        return $content;       
    }
    function checkFields2($tabID, $fieldValue, $brin) {
        $query = "SELECT *
                  FROM Profile_SchoolContext 
                  WHERE BRIN='$brin' AND tabID='$tabID'";
        
        $content = $this->handleQuery($query);
        
        return $content;       
    }
    
    //Query function used to upload edited data to a temporary table
    function uploadField($fieldName, $fieldValue, $BRIN, $email) {
        
        $query = "INSERT INTO Profile_Temp 
                 SET BRIN='$BRIN', emailAddress='$email', contentName='$fieldName', content='$fieldValue'
                 ON DUPLICATE KEY UPDATE content='$fieldValue', comment=null";
        
        $content = $this->writeQuery($query);
        
        return $content;
    }
    
    //Query function used to determine in which areas all students live
    function getStudentArea($BRIN, $YEAR){
       $query = "SELECT Profile_StudentAreaDET.total, Profile_StudentAreaDET.WijkNr, Profile_Area.areaName
                FROM Profile_StudentAreaDET
                INNER JOIN Profile_Area ON Profile_StudentAreaDET.WijkNr = Profile_Area.areaCode
                WHERE Profile_StudentAreaDET.BRIN = '$BRIN' AND Profile_StudentAreaDET.year = '$YEAR'
                ORDER BY Profile_StudentAreaDET.total desc";
       
       $content = $this->handleQuery($query);
        
       return $content;
   }
   
   //Query function to retreive temporary data from the temp table
   function downloadTemp($BRIN) {
       $query = "SELECT contentName, content FROM Profile_Temp WHERE BRIN='$BRIN'";
       
       $content = $this->handleQuery($query);
       
       return $content; 
   }
   
   //Query function to upload approved temporary data to the school table
   //and to delete that data from the temporary table
   function changeApproved($type, $content, $BRIN) {
       $query = "UPDATE Profile_School
                SET $type = '$content'
                WHERE BRIN = '$BRIN'";
       
       $query2 = "DELETE FROM Profile_Temp
                 WHERE BRIN = '$BRIN' AND contentName='$type'";
       
       $content = $this->writeQuery($query);
       $content = $this->writeQuery($query2);
       
       return $content;
   }
   
   //Query function to upload a comment to a temporary datafield in the temp.table 
   //when a field has not been approved
   function commentDisapproved($BRIN, $email, $type, $content, $comment) {
       $query2 = "DELETE FROM Profile_Temp
                 WHERE BRIN = '$BRIN' AND contentName='$type'";
       
       $query = "INSERT INTO Profile_Temp
                VALUES('$BRIN', '$email', '$type', '$content', '$comment')";
       $content = $this->writeQuery($query2);
       $content = $this->writeQuery($query);
       return $content;
   }
   
   //Query function to retrieve all temporary data available for a particular school
   function getTempData($BRIN) {
       $query = "SELECT * FROM Profile_Temp WHERE BRIN='$BRIN'";
       $content = $this->handleQuery($query);
       return $content;
   }
   
   //Query function to retrieve all info available on a particular criterium:
   function getCriteriaInfo($ID) {
       $variable = "WHERE criteriaValueID='$ID'";
       $query = "SELECT Core_CriteriaValues.criteriaType, Core_CriteriaValues.criteriaValue
                FROM Core_CriteriaValues $variable";
       $content = $this->handleQuery($query);
       return $content;
   }
   
   //Query function used to get all schools (not needed anymore?)
   function getSchoolZ($column, $criterium1, $criterium2, $criterium3, $criterium4, $criterium5, $criterium6) {
       $query = "SELECT Profile_School.BRIN, Profile_School.schoolName, Profile_School.educationTypeID, Profile_School.schoolType, Profile_School.website, 
                        Profile_School.address, Profile_School.postalCode, Profile_School.logoPath, Profile_School.childCare, Profile_School.boardID, Profile_School.emailAddress, Profile_School.schoolLat, Profile_School.schoolLong,  Profile_School.mission, Profile_School.vision,
                        Profile_Board.boardID, Profile_Board.boardName, Profile_EducationType.educationTypeID, Profile_EducationType.educationType

                        FROM Profile_School
                        INNER JOIN Profile_Board ON Profile_School.boardID = Profile_Board.boardID 
                        INNER JOIN Profile_EducationType ON Profile_School.educationTypeID = Profile_EducationType.educationTypeID
                        WHERE $column='$criterium1' 
                          OR $column='$criterium2'
                          OR $column='$criterium3'
                          OR $column='$criterium4'
                          OR $column='$criterium5'
                          OR $column='$criterium6'";
       $content = $this->handleQuery($query);
       return $content;
   }
   
   //Query function used to determine the level of a logged in user (backend)
   function grabUserLevel($veriCode, $username) {
       $query = "SELECT Core_Users.accessLevel
                FROM Core_Users
                WHERE name='$username' AND authCode='$veriCode'";
        $content = $this->handleQuery($query);
        return $content;
   }
   
   //Query function used to determine what rights a user has
   function grabUserRights($userLevel) {
       $query = "SELECT Core_Access.viewOnly, Core_Access.edit
                FROM Core_Access
                WHERE accessLevel='$userLevel'";
       $content = $this->handleQuery($query);
       return $content;
   }
   
   //Query function used to retrieve the name of a particular page
   function getPageName($pageID) {
       $query = "SELECT Core_Page.pageName
                FROM Core_Page
                WHERE pageID='$pageID'";
       $content = $this->handleQuery($query);
       return $content;
   }
   
   //Query function used to remove a particular school
   function removeItemSchool($BRIN) {
       $query = "DELETE FROM Profile_School
                 WHERE BRIN = '$BRIN'";
       $content = $this->writeQuery($query);
       return "success";
   }
   
   //Query function used to retrieve the business data of a particular school
   function getBusinessData($BRIN){
     $query = "SELECT Profile_School.directieleden, Profile_School.directieledenFTE, Profile_School.onderwijzendPersoneel, Profile_School.onderwijzendPersoneelFTE, Profile_School.onderwijsOndersteunendPersoneel, Profile_School.onderwijsOndersteunendPersoneelFTE,
            Profile_School.mannen, Profile_School.mannenFTE, Profile_School.vrouwen, Profile_School.vrouwenFTE, Profile_School.ziekteverzuim
            FROM Profile_School
            WHERE Profile_School.BRIN = '$BRIN'";  
     $content = $this->handleQuery($query);
     return $content;
     }
     function getInspectionResults($BRIN){
         $query = "SELECT Profile_Inspection.BRIN, Profile_Inspection.inspectionResultID, Profile_Inspection.inspectionURL, Profile_InspectionResult.resultDescription
                FROM Profile_Inspection
                INNER JOIN Profile_InspectionResult ON Profile_InspectionResult.inspectionResultID = Profile_Inspection.inspectionResultID
                WHERE Profile_Inspection.BRIN = '$BRIN'";  
     $content = $this->handleQuery($query);
     return $content;
     }
     //Old Query
     function getDLEData($BRIN, $schoolyear, $gradeyear){
         $query = " SELECT Profile_Growth.StudentID_ESIS, Profile_Growth.schoolYear, Profile_Growth.testType, Profile_Growth.DLE FROM Profile_Growth 
                    WHERE Profile_Growth.BRIN = '$BRIN' AND Profile_Growth.schoolYear = '$schoolyear' AND Profile_Growth.gradeYear = '$gradeyear' AND (Profile_Growth.testType='Begr.lezen' OR Profile_Growth.testType='Spelling' OR Profile_Growth.testType='Rek. en Wisk.') ORDER BY Profile_Growth.StudentID_ESIS DESC, Profile_Growth.testType DESC";
     $content = $this->handleQuery($query);
     return $content;
     }
     function getDLEData2($BRIN, $schoolyearStart, $schoolyearEnd){
         $query = "SELECT Profile_Growth.StudentID_ESIS, Profile_Growth.gradeYear, Profile_Growth.schoolYear, Profile_Growth.testType, Profile_Growth.DLE, Profile_Growth.DL, (Profile_Growth.DLE/Profile_Growth.DL * 100) AS Rendement
                    FROM Profile_Growth
                        WHERE Profile_Growth.BRIN =  '$BRIN'
                        AND (Profile_Growth.schoolYear BETWEEN '$schoolyearStart' AND '$schoolyearEnd')
                         AND (Profile_Growth.testType =  'Begr.lezen' OR Profile_Growth.testType =  'Spelling' OR Profile_Growth.testType =  'Rek. en Wisk.')
                    ORDER BY  `Profile_Growth`.`StudentID_ESIS` ASC, Profile_Growth.testType ASC";
     $content = $this->handleQuery($query);
     return $content;
     }
     
     function getVOData($BRIN){
         $query = " SELECT DISTINCT Profile_StudentVO.studentID, Profile_StudentVO.VOGradeYEar, Profile_StudentVO.schoolYear, Profile_ILT.ILTCode, Profile_ILT.ILTDescription, Profile_ILT.ILTLevel, Profile_Advice.adviceLevel
                    FROM Profile_StudentVO
                    INNER JOIN Profile_ILT ON Profile_ILT.ILTCode = Profile_StudentVO.ILTCode
                    INNER JOIN Profile_Advice ON Profile_Advice.StudentID = Profile_StudentVO.studentID
                    WHERE Profile_Advice.BRIN = '$BRIN'
                    ORDER BY `Profile_StudentVO`.`studentID` ASC, Profile_StudentVO.schoolYear ASC ";
     $content = $this->handleQuery($query);
     return $content;
     }
      function getAdviceVOData($BRIN, $year){
         $query = " SELECT DISTINCT Profile_StudentVO.studentID, Profile_StudentVO.VOGradeYear, Profile_StudentVO.schoolYear, Profile_ILT.ILTCode, Profile_ILT.ILTDescription, Profile_ILT.ILTLevel, Profile_Advice.adviceLevel
                    FROM Profile_StudentVO
                    INNER JOIN Profile_ILT ON Profile_ILT.ILTCode = Profile_StudentVO.ILTCode
                    INNER JOIN Profile_Advice ON Profile_Advice.StudentID = Profile_StudentVO.studentID
                    WHERE Profile_Advice.BRIN = '$BRIN' AND Profile_StudentVO.schoolYear = '$year' AND Profile_StudentVO.VOGradeYear = '4'
                    ORDER BY `Profile_StudentVO`.`studentID` ASC";
          $content = $this->handleQuery($query);
     return $content;
     }
      function getTotalStudentsYearData($BRIN, $startyear, $endyear){
         $query = "SELECT total, year FROM Profile_StudentAreaDET WHERE BRIN = '$BRIN' AND year BETWEEN '$startyear' AND '$endyear'";
     $content = $this->handleQuery($query);
     return $content;
     }
     function getAdviceLevels(){
         $query = "SELECT * FROM Profile_EducationLevel WHERE educationlevel = '1' OR educationlevel = '1.5' OR educationlevel = '3' OR educationlevel = '4' OR educationlevel = '5' ";
     $content = $this->handleQuery($query);
     return $content;
     }
     function getTotalStudentsYearData2($BRIN, $startyear, $endyear){
         $query = "SELECT year, totalStudents
                   FROM Profile_StudentWeightDET
                   WHERE BRIN = '$BRIN' AND year BETWEEN '$startyear' AND '$endyear'";
     $content = $this->handleQuery($query);
     return $content;
     }
      function getTotalStudentsPrognosisData($BRIN, $startyear, $endyear){
         $query = " SELECT prognosisYear, prognosis FROM Profile_Prognosis WHERE BRIN = '$BRIN' AND prognosisYear BETWEEN '$startyear' AND '$endyear'";
     $content = $this->handleQuery($query);
     return $content;
     }
     function getCitoScore($BRIN, $year){
         $query = "SELECT citoDeelname, Profile_CitoScore.citoScore, Profile_StudentWeightDET.totalStudents, Profile_StudentWeightDET.totalStudentsWithWeight
                    FROM Profile_CitoScore 
                    INNER JOIN Profile_StudentWeightDET ON Profile_StudentWeightDET.BRIN = Profile_CitoScore.citoBRIN 
                    WHERE Profile_CitoScore.citoBRIN = '$BRIN' AND Profile_CitoScore.citoJaar = '$year' AND Profile_StudentWeightDET.BRIN = '$BRIN' AND Profile_StudentWeightDET.year ='$year'";
     $content = $this->handleQuery($query);
     return $content;
         
     }
     function getCitoStandard($perc){
         $query = "SELECT Insp_OnderGrens, Insp_Gemiddeld, Insp_BovenGrens FROM Profile_CitoStandard WHERE Insp_PecGewicht = '$perc'";
     $content = $this->handleQuery($query);
     return $content;
         
     }
     
     function getTests($BRIN){
         $query = "SELECT DISTINCT ESIS_LVS_UniekToetsID, studentID_ESIS, testType, schoolYear, gradeYear, DL, DLE
                   FROM Profile_Growth
                   WHERE BRIN = '$BRIN'";
     $content = $this->handleQuery($query);
     return $content;
     }
     function removeCategory($id) {
       $query = "DELETE FROM Core_Category
                 WHERE categoryID = '$id'";
       
       $content = $this->writeQuery($query);
     }
     function removeMenuCategory($id) {
       $query = "DELETE FROM Core_MenuCategory
                 WHERE categoryID = '$id'";
       
       $content = $this->writeQuery($query);
     }
     function removePage($id) {
       $query = "DELETE FROM Core_Page
                 WHERE categoryID = '$id'";
       
       $content = $this->writeQuery($query);
     }
     function removeCriterium($id) {
       $query = "DELETE FROM Core_Criteria
                 WHERE categoryID = '$id'";
       
       $content = $this->writeQuery($query);
     }
     function removeUserDB($id) {
       $query = "DELETE FROM Core_Users
                 WHERE userID = '$id'";
       
       $content = $this->writeQuery($query);
     }
     function getContactInfo($id) {
         $query = "SELECT Core_Article.title, Core_Article.body, Core_Category.categoryName
                  FROM Core_Article
                  INNER JOIN Core_Category ON Core_Category.categoryID = Core_Article.categoryID
                  WHERE Core_Article.pageID='$id'";
        $content = $this->handleQuery($query);
        return $content;
     }
     function getPageID($pageName) {
         $query = "SELECT Core_Page.pageID
                  FROM Core_Page
                  WHERE Core_Page.pageName='$pageName'";
        $content = $this->handleQuery($query);
        return $content;
     }
     function getTabContexts($BRIN) {
         $query = "SELECT Profile_SchoolContext.tabID, Profile_SchoolContext.context
                  FROM Profile_SchoolContext
                  WHERE BRIN='$BRIN'";
        $content = $this->handleQuery($query);
        return $content;
     }
     
     function uploadContext($BRIN, $tabID, $content) {
         $query = "INSERT INTO Profile_SchoolContext
                  SET BRIN='$BRIN', tabID='$tabID', context='$content'
                  ON DUPLICATE KEY UPDATE context='$content'";
        $content = $this->writeQuery($query);
        return $content;
     }
     
     function deleteTempData($BRIN) {
         $query = "DELETE FROM Profile_Temp WHERE BRIN='$BRIN'";
         $content = $this->writeQuery($query);
         return $content; 
     }
     
     function addContentArticle($postArray) {
         $category = $postArray['categoryID'];
         $title = $postArray['title'];
         $body = $postArray['body'];
         $author = $postArray['author'];
         $page = $postArray['pageID'];
         $date = $postArray['creationDate'];
         
         $query = "INSERT INTO Core_Article VALUES (null, '$title', '$category', '$body', '$author', '$date', null, '$author', '$page', '0', '0')";
         $content = $this->writeQuery($query);
         
         return $content;
     }
     
     function getUserDetails($id) {
         $query = "SELECT Core_Users.name, Core_Users.emailAddress,  Core_Users.password, Core_Users.accessLevel
                  FROM Core_Users
                  WHERE userID='$id'";
         
         $content = $this->handleQuery($query);
         
         return $content;
     }
     function addNewUser($postArray) {
         $name = $postArray['name'];
         $emailAddress = $postArray['emailAddress'];
         $password = $postArray['password'];
         $accessLevel = $postArray['accessLevel'];
         
         $query = "INSERT INTO Core_Users VALUES (null, '$name', '$emailAddress', '$password', '$accessLevel', null, null)";
         $content = $this->writeQuery($query);
         
         return $content;
     }
     function getFullCriteriaValues($criteriaType) {
         $query = "SELECT Core_CriteriaValues.criteriaValueName, Core_CriteriaValues.criteriaValue
                  FROM Core_CriteriaValues
                  WHERE criteriaType='$criteriaType'";
         $content = $this->handleQuery($query);
         return $content;
     }
     function getPageInfotext($pageName) {
         $query = "SELECT Core_Page.infotext FROM Core_Page WHERE pageName='$pageName'";
         $content = $this->handleQuery($query);
         return $content;
     }
     function downloadSchoolEmail($BRIN) {
         $query = "SELECT Profile_School.emailaddress FROM Profile_School WHERE BRIN='$BRIN'";
         $content = $this->handleQuery($query);
         return $content;
     }
     function getTabText($tabID){
         $query = "SELECT Profile_Tab.tabtext FROM Profile_Tab WHERE tabID='$tabID'";
         $content = $this->handleQuery($query);
         return $content;
     }
     function uploadLogoPath($BRIN){
         $query = "UPDATE Profile_School SET logoPath='ja' WHERE BRIN='$BRIN'";
         $content = $this->writeQuery($query);
         return $content;
     }
}
?>