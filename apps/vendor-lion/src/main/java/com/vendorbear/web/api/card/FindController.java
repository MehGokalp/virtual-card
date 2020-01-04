package com.vendorbear.web.api.card;

import com.vendorbear.exception.CardNotFoundException;
import com.vendorbear.schema.Card;
import com.vendorbear.service.card.FindCardService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping(value = "/api/card")
public class FindController {

    private final FindCardService findCardService;

    public FindController(FindCardService findCardService) {
        this.findCardService = findCardService;
    }

    @RequestMapping(method = RequestMethod.GET, value = "/find/{cardReference}")
    public Card findCard(@PathVariable(value = "cardReference") String cardReference) throws CardNotFoundException {
        Card card = findCardService.find(cardReference);

        if (card == null) {
            throw new CardNotFoundException(cardReference);
        }

        return  card;
    }
}
