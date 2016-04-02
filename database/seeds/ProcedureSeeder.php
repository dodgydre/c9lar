<?php

use Illuminate\Database\Seeder;
use App\Procedure;

class ProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $codes = array('003','004','004A','005','006','007','008','010','011','012','013','014','015','016','017','018','020','021','040','050','111','112','141','445','5','565','6','888','999','ACUBALL','ACUMINI','ADJINC','ADMINFEE','AEXPRESS','ANKLEBRACE','ASUDAL','ATLINS','AVIVA','AXAGENERAL','BACKREST','BCPMT','BFGEL','BFPMT','BFRO','BFSPRAY','BLUECROSS','CAU','CFWP','CHEQ','CHILD','CITY','CLAISEC','COCHADJ','COI','CONSFEE','CONSLT','COOP','COPYPMT','COSECO','CQ','CTD','CUSTBUILT','CUSTOMWORK','DJPMT','DOM','ELBOW','EPSOM','ESTIMATE','ESTIMATES','EYEPACK','FILECOPY','FOAMRLHD','FREEZE','GRNSLD','GROSOU','GWLPMT','HB','HEELLIFT','HOURS','ICEPACK','ICEPACKLG','ICEPILLOW','IDUSALPMT','IE','IEMVA','INIWHSCC','INSERT','INTACT','JOHNS','JOHNSON','KNEEPILLOW','LOMBARD','LUMBPK','MANU','MC','MIDCORE','MINITHUMP','MISCE','MLPMT','MODORTHO','MONOVIE','MVAPMT','NOTE','ORDER','ORTHO','ORTHPMT','OTHOPAEDIC','PASPMT','PILLOW','POSTURELG','POSTUREMED','POSTURESM','REPORT','REPORTFEE','REPORTPMT','REPORTS','REX','REX2','RSA','SLPMT','STIM','STM','STOCKINGS','TELEPHONE','TENS','TENSELEC','THERA','THERM','THIGH','UNIFUND','VISA','VITAMIND','WATERPILLO','WHSCCIN','WHSCCPMT','WHSCCREPOF','WHSCCREPOR','WRIST','XRAYREPORT','ZHENG');
      $types = array('A','A','A','A','A','A','A','N','J','M','N','L','J','J','M','M','A','I','H','B','A','O','J','M','B','O','A','A','J','B','B','I','A','A','A','I','I','I','I','B','I','B','M','A','B','N','I','B','M','A','I','I','A','A','A','A','I','N','I','A','A','A','B','I','I','B','B','B','A','B','A','B','M','I','I','I','I','B','A','A','B','B','I','A','A','A','A','I','T','I','B','I','B','I','M','B','B','A','I','A','A','I','A','B','A','O','A','I','B','B','B','B','A','A','I','A','A','A','I','I','A','A','A','A','B','A','B','B','A','I','O','B','A','I','I','A','I','A','A','A');
      $descriptions = array('Omit','Chiropractic Adjustment','After Hours Adjustment','Chiropractic Adjustment (RCMP)','Chiropractic Adjustment (WHSCC)','Chiropractic Adjustment $30','Chiropractic Adjustment (MVA)','Iniatial Exam Copayment','Debit CA Copayment','Initial Exam Payment (60)','Chiropractic Adjustment Payment','Credit Card Copayment','Blue Cross Payment','Cash copayment','Debit Payment','Cash Payment','Initial Visit','Convergys Payment','Orthopaedic Shoes','Custom Built & Moulded Orthopaedic Shoes','RE-Schedule','Orthotic insert payment','Inactive','TENS Payment','Lumbar Support -Portable','Orthopedic PMT','Chiroflow Comfort Seat','Chiropractic Treatment(Extremity)','WRITE OFF ACCOUNT','Acuball','Acuball Mini','Adjustors Incorporated','Administrative Fee','American Express','ANKLE SUPPORT BRACE','Assurances Dalbec','Atlantic Insurance','Aviva Insurance','AXA General Insurance Payment','Chiroflow Back Support','Blue Cross Payment','Biofreeze Analgesique','Biofreeze PMT','Biofreeze Roll ON Analgesique','BioFreeze Spray','Blue Cross Payment','The Canadian Union','Chiroflow Water Pillow','Cheque','Child Initial Exam','City of St. Johns','Claim Secure Insurance','Chiropractic Adjustment Copay','Custom Moulded Orthotic Inserts','Consultation Fee','Patient Consultation','THE CO-OPERATORS','File Copy Payment','Coseco Insurance','Cheque Payment','Cervical Traction Device','Custom Mould Orthotic - Orthopaedic Shoe','Custom Moulded  Orthopaedic Work Boots','Desjardins Insurance Payment','Dominion','Epilock Tennis Elbow Splint','Epsom Salts','Estimate Orthopaedic Shoes','Custom Built Orthotic Insert','Eye Therapy Pack','Copy Fee','High Density Foam Roller','Freeze Account long standing UPB','Greensheild Payment','Group Source','Great West Life Payment','Hb Group Insurance','Heel Lift','Report','Rapid Relief Compress Packs','Hot - Cold Pack - Large','Headache Ice Pillow','Industrial Alliance Payment','Initial Examination','Initial Exam MVA','WHSCC Initial Examination','Off The Shelf Insert','Intact Insurancce','Insurance','Johnson Inc','Knee Pillow - Leg Spacer','Lombard Canada','Lumbar Therapy Pack','Manulife','MasterCard','Mid-Core Pillow','Mini Thumper','Miscelanous','Maritime - Manulife Payment','Modified Orthotic Footwear','Monovie','MVA payment','Note on File','Order date of Orthotic Inserts','Custom Orthoitic Inserts','Custom Orthortic Inserts PMT','Custom Moulded OrthopedicShoes','Provincial Adjusting Services Payment','TriCore Pillow','Posture Perfector','Posture Perfector Medium','Posture Perfector Small','Report Fee','half Hour Chiropractic Report','Report Fee Payment','1.5 Hours','Re-Exam - 1 Year','ReExam- 2 Year','Royal Sun Alliance','Sunlife payment','STIM (IFC)','Stimulation','Knee-Compression Hoisery','Telephone consultation fee','TENS machine','TENS electrodes','Theraband','Thermophore Heat Pad','Thigh-Compression Hosiery','Unifund','Credit Card Payment','Vitamin D Supplement','Chiro Flow Water Pillow','WHSCC Initial Exam Payment','WHSCC Payment','WHSCC Report Fee','WHSCC report fee','Carpal Tunnel Wrist Brace','Chiropractic X-Ray Report Fee','Zheng Giu Shui');
      $amounts = array(0,45,55,40,45,30,45,16,7,60,40,20,35,20,45,35,80,40,475,250,0,450,450,150,90,450,60,20,0,45,30,0,0,0,70,0,0,0,0,90,28,20,20,20,20,33.6,0,60,0,0,0,0,8,350,0,0,0,0,0,0,60,0,600,33.6,0,32,15,0,350,15,25,65,0,0,0,0,0,7,0,8,12,72,0,70,0,74.5,0,0,0,0,25,0,30,0,0,80,350,0,0,150,0,0,0,0,350,350,0,0,82,0,40,40,70,70,0,0,60,80,0,0,25,20,80,35,150,20,5,100,95,0,0,15,60,65,45,0,20,200,25,0);

      for ($i = 0; $i < count($codes); $i++) {
        DB::table('procedures')->insert([
          'code' => $codes[$i],
          'type' => $types[$i],
          'description' => $descriptions[$i],
          'amount' => $amounts[$i]
          //'created_at' => \Carbon\Carbon::now(),
          //'updated_at' => \Carbon\Carbon::now()
        ]);
      }


/*
        $procedure1 = new Procedure;
        $procedure1->code = 'CA';
        $procedure1->type = 'A';
        $procedure1->description = 'Chiropractic Adjustment';
        $procedure1->amount = 45;
        $procedure1->save();

        $procedure2 = new Procedure;
        $procedure2->code = 'RMT45';
        $procedure2->type = 'A';
        $procedure2->description = '45 Minute Massage';
        $procedure2->amount = 90;
        $procedure2->save();

        $procedure3 = new Procedure;
        $procedure3->code = 'VISA';
        $procedure3->type = 'L';
        $procedure3->description = 'Credit Card Payment';
        $procedure3->save();

        $procedure4 = new Procedure;
        $procedure4->code = 'BLUECROSS';
        $procedure4->type = 'I';
        $procedure4->description = 'Blue Cross Payment';
        $procedure4->amount = 10;
        $procedure4->save();
*/
    }
}
