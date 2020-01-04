package com.vendorbear.web.api.card;

import com.vendorbear.schema.Card;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping(value = "/api/card")
public class RemoveController {

    @RequestMapping(method = RequestMethod.GET, value = "/remove/{cardReference}")
    public Card findCard(@PathVariable(value = "cardReference") String cardReference) {
        return new Card();
    }
}
