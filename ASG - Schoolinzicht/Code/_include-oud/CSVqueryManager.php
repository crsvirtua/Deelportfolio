<?php
//Designed and written in the year 2012, for ASG, by:
//Peter van Kleef, Richard Floris & Pepijn de Vries.

require_once INCLUDE_DBMANAGER;

class CSVqueryManager extends dbManager {
    
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
    function writeQuery1($query) {
        $this->manager = new dbManager();
        $this->manager->openConnection();
        $this->manager->executeQuery($query);
        $this->manager->closeConnection(); 
    }
    
    function Tbl_OnderwijsConcept($pathANDname) {
        // Tbl_OnderwijsConcept  -->  Profile_EducationType
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_EducationType
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@col1,
            @OnderwijsConcept_Concept) 
            SET
            educationType=@OnderwijsConcept_Concept; 
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }
    
    function Tbl_Bestuur($pathANDname) {
        // Tbl_Bestuur  -->  Profile_Board
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_Board
            FIELDS TERMINATED BY ','   
            IGNORE 1 LINES
            (@col1,
            @Best_Bestuur)
            SET 
            boardName=@Best_Bestuur;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }
    
    function Tbl_Wijknaam($pathANDname) {
        // Tbl_Wijknaam  -->  Profile_Area
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_Area
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@Wijk_WijkNr,
            @Wijk_WijkNaam) 
            SET 
            areaCode=@Wijk_WijkNr, 
            areaName=@Wijk_WijkNaam;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }
    
    function Tbl_OnderwijsNiveau($pathANDname) {
        // Tbl_OnderwijsNiveau  -->  Profile_EducationLevel
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_EducationLevel
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@Niveau_Index,
            @Niveau_Omschrijving)
            SET
            educationLevel=@Niveau_Index, 
            educationDescription=@Niveau_Omschrijving;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

    function Tbl_ILTcode($pathANDname) {
        // Tbl_ILTcode  -->  Profile_ILT
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_ILT
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@ILT_ILTCode, @ILT_niveau,
            @col3,
            @ILT_NiveauIndex)
            SET
            ILTCode=@ILT_ILTCode, 
            ILTDescription=@ILT_niveau, 
            ILTLevel=@ILT_NiveauIndex;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

    function Tbl_Citoscore($pathANDname) {
        // Tbl_Citoscore --> Profile_CitoScore
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_CitoScore
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@1,
            @Cito_jaar,
            @Cito_BRIN,
            @Cito_Aantll,
            @Cito_Deelname,
            @Cito_Score,
            @Cito_GLG)
            SET
            citoJaar=@Cito_jaar, 
            citoBRIN=@Cito_BRIN,
            citoAantalLeerlingen=@Cito_Aantll,
            citoDeelname=@Cito_Deelname,
            citoScore=@Cito_Score,
            citoGLG=@Cito_GLG;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

    function Tbl_PrognoseLL($pathANDname) {
        // Tbl_PrognoseLL --> Profile_Prognosis 
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_Prognosis
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@PrognLL_Brin,
            @2,
            @PrognLL_PrognoseJaar,
            @PrognLL_AantalLL)
            SET 
            BRIN=@PrognLL_Brin,
            prognosisYear=@PrognLL_PrognoseJaar,
            prognosis=@PrognLL_AantalLL;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

    function Tbl_Postcode_Coordinaten($pathANDname) {
        // Tbl_Postcode_Coordinaten  -->  Profile_PostcalCode
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_PostalCode
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@Postc_Postcode,
            @col2,
            @Postc_WijkNr,
            @Postc_X_COORD,
            @Postc_Y_COORD)
            SET 
            postalCode=@Postc_Postcode, 
            areaCode=@Postc_WijkNr, 
            xCoordinate=@Postc_X_COORD, 
            yCoordinate=@Postc_Y_COORD;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

    function Profile_School_Query($pathANDname) {
        // Tbl_School, tbl_School_ID, Tbl_Vestiging, LinkTbl_Vestiging_School, Tbl_OnderwijsType (JOINED AS Profile_School_Query.csv)-->  Profile_School
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_School
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@School_Brin, 
            @SchoolGeg_SchoolNaam, 
            @OnderwijsType_Type, 
            @Vestiging_Adres, 
            @Vestiging_Postcode, 
            @SchoolGeg_Bestuur_ID,
            @OnderwijsConcept_Concept,
            @Vestiging_X_COORD,
            @Vestiging_Y_COORD,
            @10)  
            SET 
            BRIN=@School_Brin, 
            schoolName=@SchoolGeg_SchoolNaam, 
            educationTypeID=@OnderwijsConcept_Concept,
            schoolType=@OnderwijsType_Type,
            address=@Vestiging_Adres,
            postalCode=@Vestiging_Postcode, 
            boardID=@SchoolGeg_Bestuur_ID,
            xCoordinate=@Vestiging_X_COORD,
            yCoordinate=@Vestiging_Y_COORD;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

    function Tbl_ESIS_Leerlingen($pathANDname) {
        // Tbl_ESIS_Leerlingen --> Profile_Student
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_Student
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@1,
            @2,
            @ESIS_BrinVest,
            @4,
            @5,
            @6,
            @ESIS_EsisIdendificatienummer,
            @8,
            @9,
            @10,
            @11,
            @ESIS_Postcode,
            @ESIS_Inschrijfdatum,
            @ESIS_Gewicht)
            SET
            BRIN=@ESIS_BrinVest,
            studentID_ESIS=@ESIS_EsisIdendificatienummer,
            weightType=@ESIS_Gewicht,
            ESIS_Inschrijfdatum=@ESIS_Inschrijfdatum,
            postalCode=@ESIS_Postcode;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    



    function Tbl_LLPerWijk($pathANDname) {
        // Tbl_LLPerWijk  -->  Profile_StudentAreaDET
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_StudentAreaDET
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@1,
            @LLPerWijk_Jaar,
            @LLPerWijk_Brin,
            @LLPerWijk_WijkNr,
            @LLPerWijk_Onderbouw,
            @LLPerWijk_Bovenbouw,
            @LLPerWijk_Totaal)
            SET 
            BRIN=@LLPerWijk_Brin,
            year=@LLPerWijk_Jaar,
            upper=@LLPerWijk_Bovenbouw,
            lower=@LLPerWijk_Onderbouw,
            total=@LLPerWijk_Totaal,
            wijkNr=@LLPerWijk_WijkNr;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

    function Tbl_LLGewichtPO($pathANDname) {
        // Tbl_LLGewichtPO  -->  Profile_StudentWeightDET
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_StudentWeightDET
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@Gew_BRIN, 
            @Gew_KalenderJaar, 
            @3, @Gew_AantLL_0, 
            @Gew_AantLL_025, 
            @Gew_AantLL_030, 
            @Gew_AantLL_040, 
            @Gew_AantLL_070, 
            @Gew_AantLL_090, 
            @Gew_AantLL_120, 
            @Gew_totaalAantLL, 
            @Gew_AantLLGewicht, 
            @Gew_PercLLGewicht, 
            @14, @Gew_TotGewicht, 
            @Gew_GemGewicht, 
            @17)
            SET BRIN=@Gew_BRIN,
            year=@Gew_KalenderJaar,
            totalWeight0=@Gew_AantLL_0,
            totalWeight025=@Gew_AantLL_025,
            totalWeight030=@Gew_AantLL_030,
            totalWeight040=@Gew_AantLL_040,
            totalWeight070=@Gew_AantLL_070,
            totalWeight090=@Gew_AantLL_090,
            totalWeight120=@Gew_AantLL_120,
            totalStudents=@Gew_totaalAantLL,
            totalStudentsWithWeight=@Gew_AantLLGewicht,
            totalPercWeight=@Gew_PercLLGewicht,
            totalWeight=@Gew_TotGewicht,
            avgWeight=@Gew_GemGewicht;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

    function Tbl_POVO($pathANDname) {
        // Tbl_POVO  -->  Profile_Advice
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_Advice
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@1,
            @POVO_BSN,
            @3,
            @4,
            @POVO_BrinBS,
            @6,
            @7,
            @8,
            @POVO_AdviesIndex)
            SET 
            BRIN=@POVO_BrinBS, 
            studentID=@POVO_BSN, 
            adviceLevel=@POVO_AdviesIndex;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

/*    function Tbl_ESIS_Toetsen($pathANDname) {
        // Tbl_ESIS_Toetsen  -->  Profile_Growth
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_Growth
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@ESIS_LVS_UniekToetsID,
            @2,
            @ESIS_LVS_BrinVest,
            @ESIS_LVS_EsisIdentificatienummer, 
            @ESIS_LVS_Vormingsgebied,
            @6,
            @7,
            @ESIS_LVS_Schooljaar,
            @ESIS_LVS_Afnamedatum,
            @ESIS_LVS_Leerjaar,
            @11,
            @ESIS_LVS_DL,
            @13,
            @14,
            @ESIS_LVS_DLE)
            SET
            ESIS_LVS_UniekToetsID=@ESIS_LVS_UniekToetsID,
            studentID_ESIS=@ESIS_LVS_EsisIdentificatienummer,
            BRIN=@ESIS_LVS_BrinVest,
            testDate=@ESIS_LVS_Afnamedatum,
            testType=@ESIS_LVS_Vormingsgebied,
            schoolYear=@ESIS_LVS_Schooljaar,
            gradeYear=@ESIS_LVS_Leerjaar,
            DL=@ESIS_LVS_DL,
            DLE=@ESIS_LVS_DLE;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    } 
*/    
        function Tbl_ESIS_Toetsen($pathANDname) {
        // Tbl_ESIS_Toetsen  -->  Profile_Growth
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_Growth
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@ESIS_LVS_UniekToetsID,
            @2,
            @ESIS_LVS_Schooljaar,
            @ESIS_LVS_BrinVest,
            @ESIS_LVS_EsisIdentificatienummer, 
            @ESIS_LVS_Leerjaar,
            @ESIS_LVS_Vormingsgebied,
            @8,
            @9,
            @10,
            @ESIS_LVS_Afnamedatum,
            @ESIS_LVS_DL,
            @ESIS_LVS_DLE)
            SET
            ESIS_LVS_UniekToetsID=@ESIS_LVS_UniekToetsID,
            studentID_ESIS=@ESIS_LVS_EsisIdentificatienummer,
            BRIN=@ESIS_LVS_BrinVest,
            testDate=@ESIS_LVS_Afnamedatum,
            testType=@ESIS_LVS_Vormingsgebied,
            schoolYear=@ESIS_LVS_Schooljaar,
            gradeYear=@ESIS_LVS_Leerjaar,
            DL=@ESIS_LVS_DL,
            DLE=@ESIS_LVS_DLE;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }

    function Tbl_SchoolLoopbaanVO($pathANDname) {
        // Tbl_SchoolLoopbaanVO -->  Profile_StudentVO
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_StudentVO
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@LoopbVO_BSN,
            @2,
            @LoopbVO_ILTCode,
            @LoopbVO_Leerjaar,
            @5,
            @6,
            @LoopbVO_Schooljaar)
            SET
            studentID=@LoopbVO_BSN,
            VOGradeYear=@LoopbVO_Leerjaar,
            schoolYear=@LoopbVO_Schooljaar,
            ILTCode=@LoopbVO_ILTCode;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

    function Tbl_Insp_Citonorm($pathANDname) {
        // Tbl_Insp_Citonorm.csv  -->  Profile_Citostandard
        $query = "
            LOAD DATA LOCAL INFILE '$pathANDname'
            INTO TABLE Profile_CitoStandard
            FIELDS TERMINATED BY ','
            IGNORE 1 LINES
            (@Insp_PecGewicht, @Insp_OnderGrens, @Insp_Gemiddeld, @Insp_BovenGrens)
            SET
            Insp_PecGewicht=@Insp_PecGewicht,
            Insp_OnderGrens=@Insp_OnderGrens,
            Insp_Gemiddeld=@Insp_Gemiddeld,
            Insp_BovenGrens=@Insp_BovenGrens;
        ";
        $content = $this->writeQuery1($query);
        return $content; 
    }    

}
    
?>
