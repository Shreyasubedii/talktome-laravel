from fastapi import FastAPI
from pydantic import BaseModel
from transformers import pipeline

app = FastAPI()

print("Loading emotion model...")

classifier = pipeline(
    "text-classification",
    model="SamLowe/roberta-base-go_emotions",
    top_k=None
)

print("Model loaded!")


class JournalRequest(BaseModel):
    text: str


@app.post("/analyze")
def analyze_emotion(data: JournalRequest):

    results = classifier(data.text)

    sorted_results = sorted(
        results[0],
        key=lambda x: x["score"],
        reverse=True
    )

    # Keep the top 5 emotions
    top_five = sorted_results[:5]

    emotion_scores = {}

    for item in top_five:
        emotion_scores[item["label"]] = round(
            item["score"] * 100,
            2
        )

    # return {
    #     "primary_emotion": top_five[0]["label"],
    #     "secondary_emotion": top_five[1]["label"],
    #     "emotion_scores": emotion_scores
    # }

    return {
    "primary_emotion": top_five[0]["label"],
    "secondary_emotion": top_five[1]["label"],
    "confidence": round(top_five[0]["score"] * 100, 2),
    "emotion_scores": emotion_scores
}