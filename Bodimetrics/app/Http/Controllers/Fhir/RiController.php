<?php
namespace App\Http\Controllers\Fhir;
use Illuminate\Routing\Controller;

/**
 *
 */
class RiController extends Controller
{

  function Ri(){
    $resourceJson = file_get_contents("php://input");
    $resourceData = json_decode($resourceJson);

    $resourceType = $resourceData->resourceType;

    if ($resourceType == 'RothmanQuestions') {
      // request for questions
      $response = '[{
          "id": "1",
          "active": "1",
          "category": "Cardiac\/Heart",
          "question": "Do you ever feel that your heart is fluttering or skipping a beat or have you had any shortness of breath or dizziness or chest pain? ",
          "qorder": "1",
          "language": "en"
        }, {
          "id": "2",
          "active": "1",
          "category": "Food\/Nutrition",
          "question": "Do you have difficulty chewing or swallowing your food, or have you had a loss of appetite?",
          "qorder": "2",
          "language": "en"
        }, {
          "id": "3",
          "active": "1",
          "category": "Gastrointestinal\/Digestive",
          "question": "Have you been sick to your stomach, vomited or have any pain or tenderness in your belly area or noticed changes in your bathroom habits or the color of your stools?  ",
          "qorder": "3",
          "language": "en"
        }, {
          "id": "4",
          "active": "1",
          "category": "Genitorurinary\/Urine",
          "question": "Does it hurt or burn when you pee or have you noticed that your urine is cloudy or a different color or noticed a rash, lesions or unusual discharge from your genital area? ",
          "qorder": "4",
          "language": "en"
        }, {
          "id": "5",
          "active": "1",
          "category": "Bowel Incontinence",
          "question": "Do you ever soil your underwear with BM? ",
          "qorder": "5",
          "language": "en"
        }, {
          "id": "6",
          "active": "1",
          "category": "Urinary Incontinence",
          "question": "Do you ever find that you were unaware you had to go to the bathroom and your underwear was wet? ",
          "qorder": "6",
          "language": "en"
        }, {
          "id": "7",
          "active": "1",
          "category": "Musculoskeletal\/Self Care",
          "question": "Do you have painful or swollen joints in either your hands or feet, or muscle weakness that make it difficult to dress yourself or get in and out of a bed or chair by yourself? ",
          "qorder": "7",
          "language": "en"
        }, {
          "id": "8",
          "active": "1",
          "category": "Neurological\/Neuro",
          "question": "Are people asking you to repeat yourself because they say they do not understand what you are saying or because you did not seem to be paying attention to the conversation?",
          "qorder": "8",
          "language": "en"
        }, {
          "id": "9",
          "active": "1",
          "category": "Cognitive\/Memory",
          "question": "Do you have concerns about your memory or on occasion feel confused?",
          "qorder": "9",
          "language": "en"
        }, {
          "id": "10",
          "active": "1",
          "category": "Peripheral Vascular\/Extremities",
          "question": "Do you feel any of these: your hands or feet are always cold, your legs or ankles appear swollen, your feet or hands tingle or frequently feel numb?",
          "qorder": "10",
          "language": "en"
        }, {
          "id": "11",
          "active": "1",
          "category": "Skin",
          "question": "Do you have any sores that do not seem to be healing?",
          "qorder": "11",
          "language": "en"
        }, {
          "id": "12",
          "active": "1",
          "category": "Psychosocial",
          "question": "Are concerned that you may be depressed or that you are having trouble controlling your anger or irritation with others?  ",
          "qorder": "12",
          "language": "en"
        }, {
          "id": "13",
          "active": "1",
          "category": "Respiratory",
          "question": "Do you have any of the following: shortness of breath, wheezing or coughing, or pain you take a deep breath?  ",
          "qorder": "13",
          "language": "en"
        }, {
          "id": "14",
          "active": "1",
          "category": "Safety  ",
          "question": "Have you fallen recently or have bruises or red skin from bumping into things while you walk or do you feel you are unstable on your feet and at risk for a fall? ",
          "qorder": "14",
          "language": "en"
        }]';
    } elseif ($resourceType == 'RothmanAnswers') {
      // request for RI index
      $response["ri_index"] = 55;
      $response["status"] = "ok";
    } else {
      $response["status"] = "error";
    }

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}

 ?>
