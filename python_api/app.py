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

    top_two = sorted_results[:2]

    emotion_scores = {}

    for item in top_two:
        emotion_scores[item["label"]] = round(
            item["score"] * 100,
            2
        )

    return {
        "primary_emotion": top_two[0]["label"],
        "secondary_emotion": top_two[1]["label"],
        "emotion_scores": emotion_scores
    }